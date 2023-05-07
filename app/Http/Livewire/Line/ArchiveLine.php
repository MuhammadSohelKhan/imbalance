<?php

namespace App\Http\Livewire\Line;

use Livewire\Component;

use App\Models\Project;
use App\Models\Line;
use App\Models\Operation;
use App\Models\Stage;

class ArchiveLine extends Component
{
	public $newLine, $oprCount;
	public $aUser;
	public $keep_data = 1;
	public $project_id, $buyer, $style, $item, $study_date,
		$floor, $line, $allowance, $achieved,
		$toUpdateOpr, $type, $machine, $allocated_man_power, $line_id,
		$step1, $step2, $step3, $step4, $step5, $operation_id;

	public function mount($line_id)
	{
		$this->aUser = auth()->user();

		$this->populateWithNewLine($line_id);
	}

	public function render()
	{
		$this->dispatchBrowserEvent('refreshJSVariables');
		$project = Project::find($this->newLine->project_id);

		if (! $project) {
			return abort(404);
		}

		$newLine = $this->newLine;

		return view('livewire.line.archive-line', compact('project', 'newLine'))->extends('lines.archive_line');
	}

	public function updateLine()
	{
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

		$updatedLine = $this->newLine->update($lineData);

		if ($updatedLine) {
			$this->resetAllPublicVariables();
			session()->flash('success', 'Line updated successfully!');
		} else {
			session()->flash('fail', 'Unable to save. Try again.');
		}
	}

    public function deleteLine()
    {
        if (in_array($this->aUser->role, ['Master','superadmin','admin'])) {
            $deletedLine = $this->newLine->delete();
            if ($deletedLine) {
                session()->flash('success', 'Data deleted successfully.');
                return redirect(route('lines', $this->newLine->project_id));
            }
        } else {
            session()->flash('fail', 'You don\'t have access to do this.');
        }
    }

	public function editOpr($i)
	{
		if ($i >= 0 && $i < $this->oprCount) {
			$targetOpr = $this->toUpdateOpr = $this->newLine->operations[$i];

			if(sizeof($targetOpr->stages)) {
				return redirect(route('edit_line', $this->newLine->id));
			}

			$this->type = $targetOpr->type;
			$this->machine = $targetOpr->machine;
			$this->allocated_man_power = $targetOpr->allocated_man_power;
		} else {
			session()->flash('fail', 'Something went wrong! Try again.');
		}
	}

	public function updateOperation($data)
	{
		$operationData = $this->validate([
			'type' => 'required|string',
			'machine' => 'required|string',
			'allocated_man_power' => 'required|integer|min:1',
			'line_id' => 'required|exists:lines,id',
		]);

		$updatedOperation = $this->toUpdateOpr->update($operationData);


		if ($updatedOperation && !sizeof($this->toUpdateOpr->stages)) {
			$stageData1 = [
				'first' => $data['step1'],
				'second' => $data['step2'],
				'third' => $data['step3'],
				'fourth' => $data['step4'],
				'fifth' => $data['step5'],
				'operation_id' => $this->toUpdateOpr->id,
			];
			$createdStage1 = Stage::create($stageData1);

			if (count($data) > 5 && count($data) <= 25 && $data['step6'] != "" && $data['step7'] != "" && $data['step8'] != "" && $data['step9'] != "" && $data['step10'] != "") {
				Stage::create([
					'first' => $data['step6'],
					'second' => $data['step7'],
					'third' => $data['step8'],
					'fourth' => $data['step9'],
					'fifth' => $data['step10'],
					'operation_id' => $this->toUpdateOpr->id,
				]);
			}
			if (count($data) > 10 && count($data) <= 25 && $data['step11'] != "" && $data['step12'] != "" && $data['step13'] != "" && $data['step14'] != ""  && $data['step15'] != "") {
				Stage::create([
					'first' => $data['step11'],
					'second' => $data['step12'],
					'third' => $data['step13'],
					'fourth' => $data['step14'],
					'fifth' => $data['step15'],
					'operation_id' => $this->toUpdateOpr->id,
				]);
			}
			if (count($data) > 15 && count($data) <= 25 && $data['step16'] != "" && $data['step17'] != "" && $data['step18'] != "" && $data['step19'] != ""  && $data['step20'] != "") {
				Stage::create([
					'first' => $data['step16'],
					'second' => $data['step17'],
					'third' => $data['step18'],
					'fourth' => $data['step19'],
					'fifth' => $data['step20'],
					'operation_id' => $this->toUpdateOpr->id,
				]);
			}
			if (count($data) > 20 && count($data) <= 25 && $data['step21'] != "" && $data['step22'] != "" && $data['step23'] != "" && $data['step24'] != ""  && $data['step25'] != "") {
				Stage::create([
					'first' => $data['step21'],
					'second' => $data['step22'],
					'third' => $data['step23'],
					'fourth' => $data['step24'],
					'fifth' => $data['step25'],
					'operation_id' => $this->toUpdateOpr->id,
				]);
			}

			if($createdStage1) {
				if (! $this->keep_data) {
					$this->resetAllPublicVariables();
				}

				$this->dispatchBrowserEvent('refreshJSVariables');
				session()->flash('success', 'Data saved successfully.');
			}
		} else {
			session()->flash('fail', 'Unable to save.');
		}
	}

    public function deleteOpr($i)
    {
        if (in_array($this->aUser->role, ['Master','superadmin','admin'])) {
			$deletedOpr = $this->newLine->operations[$i]->delete();

			if ($deletedOpr) {
				session()->flash('success', 'Data deleted successfully.');
				$this->populateWithNewLine($this->newLine->id);
			}
        } else {
            session()->flash('fail', 'You don\'t have access to do this.');
        }
    }

	public function resetModalForm()
	{
		$this->resetErrorBag();
		$this->resetAllPublicVariables();
		$this->dispatchBrowserEvent('resetModalForm');
	}

	public function populateWithNewLine($line_id)
	{
		if (in_array($this->aUser->role, ['Master','superadmin','admin'])) {
			$this->newLine = Line::where('is_archived', 0)->with(['operations'=>function ($q)
			{
				$q->with('stages')->withCount('stages');
			}])->withCount('operations')->findOrFail($this->line_id);
		} else {
			$this->newLine = Line::where('is_archived', 0)->where('created_by', $this->aUser->id)->with(['operations'=>function ($q)
			{
				$q->with('stages')->withCount('stages');
			}])->withCount('operations')->findOrFail($line_id);
		}

		$this->oprCount = $this->newLine->operations_count;

		$this->project_id = $this->newLine->project_id;
		$this->buyer = $this->newLine->buyer;
		$this->style = $this->newLine->style;
		$this->item = $this->newLine->item;
		$this->study_date = $this->newLine->study_date;
		$this->floor = $this->newLine->floor;
		$this->line = $this->newLine->line;
		$this->allowance = $this->newLine->allowance;
		$this->achieved = $this->newLine->achieved;
	}

	public function resetAllPublicVariables()
	{
		# Operation variables
		$this->toUpdateOpr = null;
		$this->type = null;
		$this->machine = null;
		$this->allocated_man_power = null;


		# Stage variables
		$this->operation_id = null;
	}
}
