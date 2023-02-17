<?php

namespace App\Http\Livewire\Summary;

use Livewire\Component;

use App\Models\Summary;
use App\Models\Line;
use App\Models\Operation;
use App\Models\Stage;

class Summaries extends Component
{
    public $currentStep = 1;
    public $totalStep = 3;
    public $keep_data = 1;
	public $company, $buyer, $style, $item, $study_date, 
        $floor, $line, $allowance, $achieved, $summary_id,
        $type, $machine, $allocated_man_power, $line_id,
        $step1, $step2, $step3, $step4, $step5, $operation_id;//$stages = [], $operation_id;

    public function render()
    {
        $this->dispatchBrowserEvent('refreshJSVariables');
    	$summaries = Summary::orderBy('id', 'desc')->limit(10)->get();
        return view('livewire.summary.summaries', compact('summaries'));
    }

    public function resetModalForm()
    {
    	$this->resetErrorBag();
    	$this->resetAllPublicVariables();
        $this->currentStep = 1;
    	$this->dispatchBrowserEvent('resetModalForm');
    }

    public function saveSummary()
    {
    	$summaryData = $this->validate([
    		'company' => 'required|string',
    		'buyer' => 'required|string',
    		'style' => 'required|string',
    		'item' => 'required|string',
    		'study_date' => 'required|date',
    	]);
    	//return $summaryData;

    	$createdSummary = Summary::create($summaryData);
        //dd($createdSummary);

    	if ($createdSummary) {
            $this->resetAllPublicVariables();
            $this->currentStep = 2;
            return $this->summary_id = $createdSummary->id;
    		//session()->flash('success', 'Summary added!');
    		//return redirect()->route('home');
    	} else {
            $this->currentStep = 1;
    		dd('error in create.');
    	}
    }

    public function saveLine()
    {
        $lineData = $this->validate([
            'floor' => 'required|integer|min:1|max:20',
            'line' => 'required|integer|min:1|max:50',
            'allowance' => 'required|integer|min:1|max:50',
            'achieved' => 'required|integer|min:40|max:90',
            'summary_id' => 'required|exists:summaries,id',
        ]);

        $createdLine = Line::create($lineData);

        if ($createdLine) {
            $this->resetAllPublicVariables();
            $this->currentStep = 3;
            return $this->line_id = $createdLine->id;
        } else {
            $this->currentStep = 2;
            dd('error in create.');
        }
    }

    public function saveOperation($data)
    {
        $operationData = $this->validate([
            'type' => 'required|string',
            'machine' => 'required|string',
            'allocated_man_power' => 'required|integer|min:1|max:5',
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
                return $this->line_id = $createdOperation->line_id;
            }
        } else {
            $this->currentStep = 2;
            dd('error in create.');
        }
    }

    public function resetAllPublicVariables()
    {
        # Summary variables
    	$this->company = null;
		$this->buyer = null;
		$this->style = null;
		$this->item = null;
		$this->study_date = null;


        # Line variables
        $this->floor = null;
        $this->line = null;
        $this->allowance = null;
        $this->achieved = null;
        $this->summary_id = null;


        # Operation variables
        $this->type = null;
        $this->machine = null;
        $this->allocated_man_power = null;
        $this->line_id = null;


        # Stage variables
        $this->operation_id = null;
    }
}