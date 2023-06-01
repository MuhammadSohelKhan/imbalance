<?php

namespace App\Http\Livewire\Line;

use Livewire\Component;

use App\Models\Project;
use App\Models\Line;
use App\Models\Operation;
use App\Models\Stage;

class Lines extends Component
{
    public $aUser;
    public $currentStep = 2, $totalStep = 3;
    public $keep_data = 1, $lineStatus = ["Active", 0];
	public $project_id, $buyer, $style, $item, $study_date,
		$floor, $line, $allowance, $achieved,
        $type, $machine, $allocated_man_power, $line_id,
        $step1, $step2, $step3, $step4, $step5, $operation_id;

    public function render()
    {
        $this->dispatchBrowserEvent('refreshJSVariables');
        $project = Project::find($this->project_id);

        if (! $project) {
            return abort(404);
        }

        $lines = Line::where('project_id', $this->project_id)
            ->where('is_archived', $this->lineStatus[1])
            ->orderBy('id', 'asc')->get();

        /*if ($this->aUser->role == 'user') {
            $lines = $lines->where('created_by', $this->aUser->id);
        }
    	$lines = $lines->orderBy('id', 'asc')->get();*/

		return view('livewire.line.lines', compact('project', 'lines'));
    }


    public function toggleLineStatus()
    {
        $this->lineStatus = ($this->lineStatus[1] == 0) ? ["Archived", 1] : ["Active", 0];
    }


    public function resetModalForm()
    {
    	$this->resetErrorBag();
    	$this->resetAllPublicVariables();
        $this->currentStep = 2;
    	$this->dispatchBrowserEvent('resetModalForm');
    }


    public function saveLine()
    {
        if ($this->aUser->role == 'viewer') abort(403);

        $lineData = $this->validate([
            'buyer' => 'required|string',
            'style' => 'required|string',
            'item' => 'required|string',
            'study_date' => 'required|date',
            'floor' => 'required|integer|min:1',
            'line' => 'required|integer|min:1',
            'allowance' => 'required|integer|min:1',
            'achieved' => 'required|integer|min:1',
            'project_id' => 'required|exists:projects,id',
        ]);

        $createdLine = Line::create($lineData);

        if ($createdLine) {
            $this->resetAllPublicVariables();
            $this->currentStep = 3;
            session()->flash('success', 'Line saved successfully!');
            return $this->line_id = $createdLine->id;
        } else {
            $this->currentStep = 2;
            session()->flash('fail', 'Unable to save.');
        }
    }

    public function saveOperation($data)
    {
        if ($this->aUser->role == 'viewer') abort(403);

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
                $this->dispatchBrowserEvent('refreshJSVariables');
                session()->flash('success', 'Data saved successfully.');
                return $this->line_id = $createdOperation->line_id;
            }
        } else {
            $this->currentStep = 3;
            session()->flash('fail', 'Unable to save.');
        }
    }


    public function resetAllPublicVariables()
    {
        # Line variables
        $this->buyer = null;
        $this->style = null;
        $this->item = null;
        $this->study_date = null;
        $this->floor = null;
        $this->line = null;
        $this->allowance = null;
        $this->achieved = null;


        # Operation variables
        $this->type = null;
        $this->machine = null;
        $this->allocated_man_power = null;
        $this->line_id = null;


        # Stage variables
        $this->operation_id = null;
    }
}