<?php

namespace App\Http\Livewire\Line;

use Livewire\Component;

use App\Models\Line;

class Lines extends Component
{
	public $summary_id;

    public function render()
    {
    	$lines = Line::where('summary_id', $this->summary_id)->orderBy('id', 'asc')->get();
        return view('livewire.line.lines', compact('lines'));
    }
}
