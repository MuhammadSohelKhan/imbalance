<?php

namespace App\Http\Livewire\Summary;

use Livewire\Component;

use App\Models\Summary;

class Summaries extends Component
{
	public $company, $buyer, $style, $item, $study_date;

    public function render()
    {
    	$summaries = Summary::orderBy('id', 'desc')->limit(10)->get();
        return view('livewire.summary.summaries', compact('summaries'));
    }

    public function resetModalForm()
    {
    	$this->resetErrorBag();
    	$this->resetAllPublicVariables();
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

    	if ($createdSummary) {
    		session()->flash('success', 'Summary added!');
    		return redirect()->route('home');
    	} else {
    		dd('error in create.');
    	}
    }

    public function resetAllPublicVariables()
    {
    	$this->company = null;
		$this->buyer = null;
		$this->style = null;
		$this->item = null;
		$this->study_date = null;
    }
}
