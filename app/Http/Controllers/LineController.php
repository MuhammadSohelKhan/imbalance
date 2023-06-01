<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Operation;
use App\Models\Stage;
use App\Http\Requests\StoreLineRequest;
use App\Http\Requests\UpdateLineRequest;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404);
    }

    public function archiveLine($line_id)
    {
        $aUser = auth()->user();
        if ($aUser->role == 'viewer') abort(403);

        $copiedLine = Line::with(['operations' => function ($q)
        {
            $q->with('stages')->withCount('stages');
        }])->withCount('operations')->findOrFail($line_id);

        if (in_array($aUser->role,['CiC','user']) && $aUser->client_id != $copiedLine->project->client_id) {
            abort(403);
        }

        $newLine = Line::create([
            'buyer' => $copiedLine->buyer,
            'style' => $copiedLine->style,
            'item' => $copiedLine->item,
            'study_date' => $copiedLine->study_date,
            'floor' => $copiedLine->floor,
            'line' => $copiedLine->line,
            'allowance' => $copiedLine->allowance,
            'achieved' => $copiedLine->achieved,
            'is_archived' => FALSE,
            'project_id' => $copiedLine->project_id,
            'copied_from' => $copiedLine->id,
        ]);

        if ($newLine && $copiedLine->operations_count) {
            foreach ($copiedLine->operations as $ind => $copiedOpr) {
                $newOpr = \App\Models\Operation::create([
                    'type' => $copiedOpr->type,
                    'machine' => $copiedOpr->machine,
                    'allocated_man_power' => $copiedOpr->allocated_man_power,
                    'line_id' => $newLine->id,
                ]);

                /*if ($newOpr && $copiedOpr->stages_count) {
                    foreach ($copiedOpr->stages as $copiedStg) {
                        \App\Models\Stage::create([
                            'first' => $copiedStg->first,
                            'second' => $copiedStg->second,
                            'third' => $copiedStg->third,
                            'fourth' => $copiedStg->fourth,
                            'fifth' => $copiedStg->fifth,
                            'operation_id' => $newOpr->id,
                        ]);
                    }
                }*/
            }
        }

        // Archiving the copied line
        if (! $copiedLine->is_archived) {
            $copiedLine->update([
                'is_archived' => 1,
                'archived_date' => date('Y-m-d')
            ]);
        }

        return redirect(route('edit_line', $newLine->id));
    }

    public function copiedLine($line_id)
    {
        return view('lines.archive_line', compact('line_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLineRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLineRequest $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function show(Line $line)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function edit(Line $line)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLineRequest  $request
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLineRequest $request, Line $line)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function destroy(Line $line)
    {
        abort(404);
    }
}
