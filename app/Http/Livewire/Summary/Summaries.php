<?php

namespace App\Http\Livewire\Summary;

use Livewire\Component;

use App\Models\Summary;
use App\Models\Line;
use App\Models\Operation;
use App\Models\Stage;

class Summaries extends Component
{
    public $stageStep = 1;
    public $currentStep = 1;

	public $company, $buyer, $style, $item, $study_date, 
        $floor, $line, $allowance, $achieved, $summary_id,
        $type, $machine, $allocated_man_power, $line_id,
        $first, $second, $third, $fourth, $fifth, $operation_id;

    public function render()
    {
    	$summaries = Summary::orderBy('id', 'desc')->limit(10)->get();
        return view('livewire.summary.summaries', compact('summaries'));
    }

    public function resetModalForm()
    {
    	$this->resetErrorBag();
    	$this->resetAllPropertyVariables();
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
            $this->resetAllPropertyVariables();
            $this->currentStep = 2;
            return $this->summary_id = $createdSummary->id;
    		//session()->flash('success', 'Summary added!');
    		//return redirect()->route('home');
    	} else {
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
            $this->resetAllPropertyVariables();
            $this->currentStep = 3;
            return $this->line_id = $createdLine->id;
        } else {
            dd('error in create.');
        }
    }

    public function saveOperation()
    {
        $operationData = $this->validate([
            'type' => 'required|string',
            'machine' => 'required|string',
            'allocated_man_power' => 'required|integer|min:1|max:5',
            'line_id' => 'required|exists:lines,id',
        ]);

        $createdOperation = Operation::create($operationData);

        if ($createdOperation) {
            $this->resetAllPropertyVariables();
            $this->currentStep = 4;
            return $this->operation_id = $createdOperation->id;
        } else {
            dd('error in create.');
        }
    }

    public function addNewStage()
    {
    	$stageData = $this->validate([
    		'first' => 'required|integer',
    		'second' => 'required|integer',
    		'third' => 'required|integer',
    		'fourth' => 'required|integer',
    		'fifth' => 'required|integer',
    		'operation_id' => 'required|exists:operations,id',
    	]);

    	$createdStage = Stage::create($stageData);

        if ($createdStage) {
            $this->resetAllPropertyVariables();
            $this->stageStep++;
            $this->currentStep = 4;
        	$this->resetErrorBag();
    		$this->dispatchBrowserEvent('resetModalForm');
            return $this->operation_id = $createdStage->operation_id;
        } else {
            dd('error in create.');
        }
    }

    public function saveStages()
    {
    	$stageData = $this->validate([
    		'first' => 'required|integer',
    		'second' => 'required|integer',
    		'third' => 'required|integer',
    		'fourth' => 'required|integer',
    		'fifth' => 'required|integer',
    		'operation_id' => 'required|exists:operations,id',
    	]);

    	$createdStage = Stage::create($stageData);

        if ($createdStage) {
            $this->resetAllPropertyVariables();
            $this->currentStep = 4;
            session()->flash('success', 'Operation stage saved.');
            return redirect()->route('home');
        } else {
            dd('error in create.');
        }
    }

    public function resetAllPropertyVariables()
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
        $this->first = null;
        $this->second = null;
        $this->third = null;
        $this->fourth = null;
        $this->fifth = null;
        $this->operation_id = null;
    }
}