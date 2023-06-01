<?php

namespace App\Http\Livewire\Operation;

use Livewire\Component;

use App\Models\Project;
use App\Models\Line;
use App\Models\Operation;
use App\Models\Stage;

class Operations extends Component
{
    public $aUser, $line, $operations, $reload = FALSE;
    public $currentStep = 3, $totalStep = 3;
    public $keep_data = 1;
	public $line_id,
        $type, $machine, $allocated_man_power,
        $step1, $step2, $step3, $step4, $step5, $operation_id;

    public function mount()
    {
        $this->aUser = auth()->user();

        $this->loadLineData();
        $this->loadOprsData();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('refreshJSVariables');

        return view('livewire.operation.operations');
    }

    public function resetModalForm()
    {
        if ($this->reload) {
            return redirect(route('operations', $this->line_id));
        }
        $this->resetErrorBag();
        $this->resetAllPublicVariables();
        $this->currentStep = 3;
        $this->loadOprsData();
        $this->dispatchBrowserEvent('DOMContentLoaded');
        $this->dispatchBrowserEvent('resetModalForm');
    }

    public function saveOperation($data)
    {
        if ($this->aUser->role=='viewer' || $this->aUser->role=='user' && $this->line->created_by != $this->aUser->id || $this->line->is_archived) abort(403);

        $operationData = $this->validate([
            'type' => 'required|string',
            'machine' => 'required|string',
            'allocated_man_power' => 'required|integer|min:1',
            'line_id' => 'required|exists:lines,id',
        ]);


        $createdOperation = Operation::create($operationData);


        if ($createdOperation) {
            $stageData1 = [
                'first' => $data['step1'],
                'second' => $data['step2'],
                'third' => $data['step3'],
                'fourth' => $data['step4'],
                'fifth' => $data['step5'],
                'operation_id' => $createdOperation->id,
            ];
            $createdStage1 = Stage::create($stageData1);

            if (count($data) > 5 && count($data) <= 25 && $data['step6'] != "" && $data['step7'] != "" && $data['step8'] != "" && $data['step9'] != "" && $data['step10'] != "") {
                Stage::create([
                    'first' => $data['step6'],
                    'second' => $data['step7'],
                    'third' => $data['step8'],
                    'fourth' => $data['step9'],
                    'fifth' => $data['step10'],
                    'operation_id' => $createdOperation->id,
                ]);
            }
            if (count($data) > 10 && count($data) <= 25 && $data['step11'] != "" && $data['step12'] != "" && $data['step13'] != "" && $data['step14'] != ""  && $data['step15'] != "") {
                Stage::create([
                    'first' => $data['step11'],
                    'second' => $data['step12'],
                    'third' => $data['step13'],
                    'fourth' => $data['step14'],
                    'fifth' => $data['step15'],
                    'operation_id' => $createdOperation->id,
                ]);
            }
            if (count($data) > 15 && count($data) <= 25 && $data['step16'] != "" && $data['step17'] != "" && $data['step18'] != "" && $data['step19'] != ""  && $data['step20'] != "") {
                Stage::create([
                    'first' => $data['step16'],
                    'second' => $data['step17'],
                    'third' => $data['step18'],
                    'fourth' => $data['step19'],
                    'fifth' => $data['step20'],
                    'operation_id' => $createdOperation->id,
                ]);
            }
            if (count($data) > 20 && count($data) <= 25 && $data['step21'] != "" && $data['step22'] != "" && $data['step23'] != "" && $data['step24'] != ""  && $data['step25'] != "") {
                Stage::create([
                    'first' => $data['step21'],
                    'second' => $data['step22'],
                    'third' => $data['step23'],
                    'fourth' => $data['step24'],
                    'fifth' => $data['step25'],
                    'operation_id' => $createdOperation->id,
                ]);
            }

            if($createdStage1) {
                if (! $this->keep_data) {
                    $this->resetAllPublicVariables();
                }

                $this->currentStep = 3;
                $this->reload = TRUE;
                $this->dispatchBrowserEvent('refreshJSVariables');
                session()->flash('success', 'Data saved successfully.');
            }
        } else {
            $this->currentStep = 3;
            session()->flash('fail', 'Unable to save.');
        }
    }

    public function loadLineData()
    {
        $this->line = Line::where('id',$this->line_id)->with(['project' => function ($q)
            {
                $q->with('client');
            }])->first();

        if (! $this->line) {
            return abort(404);
        }
    }

    public function loadOprsData()
    {
        $this->operations = Operation::where('line_id', $this->line_id)->with('stages')->withCount('stages')->orderBy('id', 'asc')->get();
    }

    public function resetAllPublicVariables()
    {
        # Operation variables
        $this->type = null;
        $this->machine = null;
        $this->allocated_man_power = null;


        # Stage variables
        $this->operation_id = null;
    }
}
