<?php

namespace App\Http\Livewire\Summary;

use Livewire\Component;

use App\Models\Summary;
use App\Models\Line;
use App\Models\Operation;

class Summaries extends Component
{
    public $currentStep = 3;
    public $totalStep = 2;
	public $company, $buyer, $style, $item, $study_date, 
        $floor, $line, $allowance, $achieved, $summary_id,
        $type, $machine, $allocated_man_power, $line_id,
        $stages = [], $operation_id;

    public function render()
    {
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
        //return $lineData;

        $createdLine = Line::create($lineData);

        if ($createdLine) {
            $this->resetAllPublicVariables();
            $this->currentStep = 3;
            return $this->line_id = $createdLine->id;
            //session()->flash('success', 'Summary added!');
            //return redirect()->route('home');
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
        //return $operationData;

        $createdOperation = Operation::create($operationData);

        if ($createdOperation) {
            $this->resetAllPublicVariables();
            $this->currentStep = 4;
            return $this->operation_id = $createdOperation->id;
            //session()->flash('success', 'Summary added!');
            //return redirect()->route('home');
        } else {
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


        # Summary variables
        $this->floor = null;
        $this->line = null;
        $this->allowance = null;
        $this->achieved = null;
        $this->summary_id = null;
    }
}