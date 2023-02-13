<?php

namespace App\Http\Livewire\Operation;

use Livewire\Component;

use App\Models\Summary;
use App\Models\Line;
use App\Models\Operation;
use App\Models\Stage;

class Operations extends Component
{
	public $line_id;

    public function render()
    {
    	$line = Line::find($this->line_id);

    	if (! $line) {
    		return abort(404);
    	}

    	$summary = Summary::findOrFail($line->summary_id);
    	$operations = Operation::where('line_id', $this->line_id)->with('stages')->withCount('stages')->orderBy('id', 'asc')->get();



        return view('livewire.operation.operations', compact('line', 'summary', 'operations'));

    	/*$operations = Operation::where('line_id', $this->line_id)->with(['stages', 'line:id,floor,line'])->withCount('stages')->orderBy('id', 'asc')->get();

    	$minCapHour = Operation::select('capacity_per_hour')->orderBy('capacity_per_hour', 'asc')->where('line_id', $this->line_id)->where('capacity_per_hour', '!=', null)->first();

    	if ($minCapHour) {
    		$minCapacity = $minCapHour->capacity_per_hour;

    		$line = Line::findOrFail($this->line_id);
    		if ($line) {
    			$line->update(['possible_output'=>$minCapacity]);
    		}
    	} else {
    		$minCapacity = NULL;
    	}*/

        return view('livewire.operation.operations'/*, compact('operations', 'minCapacity')*/);
    }
}
