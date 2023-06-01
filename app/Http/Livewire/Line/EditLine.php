<?php

namespace App\Http\Livewire\Line;

use Livewire\Component;

use App\Models\Project;
use App\Models\Line;
use App\Models\Operation;
use App\Models\Stage;

class EditLine extends Component
{
	public $newLine, $oprCount, $editStage = FALSE;
	public $aUser;
	public $keep_data = 1;
	public $project_id, $buyer, $style, $item, $study_date,
		$floor, $line, $allowance, $achieved,
		$toUpdateOpr, $type, $machine, $allocated_man_power, $line_id,
		$step1, $step2, $step3, $step4, $step5, $step6, $step7, $step8, $step9, $step10, $step11, $step12, $step13, $step14, $step15, $step16, $step17, $step18, $step19, $step20, $step21, $step22, $step23, $step24, $step25, $operation_id;

	public function mount($line_id)
	{
		$this->aUser = auth()->user();
		if ($this->aUser->role == 'viewer') abort(403);

		$this->populateWithNewLine($line_id);
	}



	public function render()
	{
		$project = Project::find($this->newLine->project_id);

		if (! $project) {
			return abort(404);
		}

        if (in_array($this->aUser->role,['CiC','user']) && $this->aUser->client_id != $project->client_id) {
            abort(403);
        }

		$this->dispatchBrowserEvent('refreshJSVariables');
		$newLine = $this->newLine;

		return view('livewire.line.edit-line', compact('project', 'newLine'))->extends('lines.archive_line');
	}



	public function updateLine()
	{
    	if ($this->aUser->role == 'user' && $this->newLine->created_by != $this->aUser->id) abort(403);

		if (in_array($this->aUser->role, ['Master','superadmin','admin','CiC', 'user'])) {
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
				$this->resetModalForm();
				session()->flash('success', 'Line updated successfully!');
				// $this->dispatchBrowserEvent('closeLineModal');
			} else {
				session()->flash('fail', 'Unable to save. Try again.');
			}
		} else {
			$this->dispatchBrowserEvent('closeLineModal');
            session()->flash('fail', 'You don\'t have access to do this.');
        }
	}



    public function deleteLine()
    {
    	if ($this->aUser->role == 'user' && $this->newLine->created_by != $this->aUser->id) abort(403);

        if (in_array($this->aUser->role, ['Master','superadmin','admin','CiC', 'user'])) {
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
    	if ($this->aUser->role == 'user' && $this->newLine->created_by != $this->aUser->id) abort(403);

		if ($this->newLine->operations->offsetExists($i)) {
			$targetOpr = $this->toUpdateOpr = $this->newLine->operations[$i];

			if($totalStg = sizeof($targetOpr->stages)) {
				$this->editStage = TRUE;

				if ($totalStg == 5) {
					$this->step21 = $targetOpr->stages[4]->first;
					$this->step22 = $targetOpr->stages[4]->second;
					$this->step23 = $targetOpr->stages[4]->third;
					$this->step24 = $targetOpr->stages[4]->fourth;
					$this->step25 = $targetOpr->stages[4]->fifth;
				}
				if ($totalStg > 3 && $totalStg < 5) {
					$this->step16 = $targetOpr->stages[3]->first;
					$this->step17 = $targetOpr->stages[3]->second;
					$this->step18 = $targetOpr->stages[3]->third;
					$this->step19 = $targetOpr->stages[3]->fourth;
					$this->step20 = $targetOpr->stages[3]->fifth;
				}
				if ($totalStg > 2 && $totalStg < 5) {
					$this->step11 = $targetOpr->stages[2]->first;
					$this->step12 = $targetOpr->stages[2]->second;
					$this->step13 = $targetOpr->stages[2]->third;
					$this->step14 = $targetOpr->stages[2]->fourth;
					$this->step15 = $targetOpr->stages[2]->fifth;
				}
				if ($totalStg > 1 && $totalStg < 5) {
					$this->step6 = $targetOpr->stages[1]->first;
					$this->step7 = $targetOpr->stages[1]->second;
					$this->step8 = $targetOpr->stages[1]->third;
					$this->step9 = $targetOpr->stages[1]->fourth;
					$this->step10 = $targetOpr->stages[1]->fifth;
				}
				if ($totalStg > 0 && $totalStg < 5) {
					$this->step1 = $targetOpr->stages[0]->first;
					$this->step2 = $targetOpr->stages[0]->second;
					$this->step3 = $targetOpr->stages[0]->third;
					$this->step4 = $targetOpr->stages[0]->fourth;
					$this->step5 = $targetOpr->stages[0]->fifth;
				}
			}

			$this->type = $targetOpr->type;
			$this->machine = $targetOpr->machine;
			$this->allocated_man_power = $targetOpr->allocated_man_power;
		} else {
			$this->dispatchBrowserEvent('closeOprModal');
			session()->flash('fail', 'Something went wrong! Try again.');
		}
	}



	public function updateOperation($data)
	{
    	if ($this->aUser->role == 'user' && $this->newLine->created_by != $this->aUser->id) abort(403);

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
				$this->resetModalForm();
				$this->dispatchBrowserEvent('closeOprModal');
				$this->dispatchBrowserEvent('refreshJSVariables');
				session()->flash('success', 'Data saved successfully.');
			}

		} elseif ($updatedOperation && $totalStg = sizeof($this->toUpdateOpr->stages)) {
			if ($totalStg == 5) {
				$this->toUpdateOpr->stages[4]->update([
					'first' => $data['step21'],
					'second' => $data['step22'],
					'third' => $data['step23'],
					'fourth' => $data['step24'],
					'fifth' => $data['step25'],
				]);
			}
			if ($totalStg > 3 && $totalStg < 5) {
				$this->toUpdateOpr->stages[3]->update([
					'first' => $data['step16'],
					'second' => $data['step17'],
					'third' => $data['step18'],
					'fourth' => $data['step19'],
					'fifth' => $data['step20'],
				]);
			}
			if ($totalStg > 2 && $totalStg < 5) {
				$this->toUpdateOpr->stages[2]->update([
					'first' => $data['step11'],
					'second' => $data['step12'],
					'third' => $data['step13'],
					'fourth' => $data['step14'],
					'fifth' => $data['step15'],
				]);
			}
			if ($totalStg > 1 && $totalStg < 5) {
				$this->toUpdateOpr->stages[1]->update([
					'first' => $data['step6'],
					'second' => $data['step7'],
					'third' => $data['step8'],
					'fourth' => $data['step9'],
					'fifth' => $data['step10'],
				]);
			}
			if ($totalStg > 0 && $totalStg < 5) {
				$this->toUpdateOpr->stages[0]->update([
					'first' => $data['step1'],
					'second' => $data['step2'],
					'third' => $data['step3'],
					'fourth' => $data['step4'],
					'fifth' => $data['step5'],
				]);
			}
			$this->resetModalForm();
			$this->dispatchBrowserEvent('closeOprModal');
			$this->dispatchBrowserEvent('refreshJSVariables');
			session()->flash('success', 'Data updated successfully.');
		} else {
			session()->flash('fail', 'Unable to save.');
		}
	}



    public function deleteOpr($i)
    {
    	if ($this->aUser->role == 'user' && $this->newLine->created_by != $this->aUser->id) abort(403);

        if (in_array($this->aUser->role, ['Master','superadmin','admin','CiC','user'])) {
			$deletedOpr = $this->newLine->operations[$i]->delete();

			if ($deletedOpr) {
				session()->flash('success', 'Data deleted successfully.');
				$this->populateWithNewLine($this->newLine->id);
			}
        } else {
            session()->flash('fail', 'You don\'t have access to do this.');
        }
    }



    public function deleteStage($i)
    {
    	if ($this->aUser->role == 'user' && $this->newLine->created_by != $this->aUser->id) abort(403);

    	if ($this->toUpdateOpr->stages->offsetExists($i)) {
    		$deletedStg = $this->toUpdateOpr->stages[$i]->delete();

    		if ($deletedStg) {
    			session()->flash('success','Time record deleted successfully!');
    		} else {
    			session()->flash('fail','Unable to delete time record!');
    		}
    	} else {
			$this->resetModalForm();
			$this->dispatchBrowserEvent('closeOprModal');
            session()->flash('fail', 'Something went wrong! Try again.');
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
		if (in_array($this->aUser->role, ['Master','superadmin','admin','CiC'])) {
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
		$this->editStage = FALSE;
		$this->operation_id = null;
		$this->step1=$this->step2=$this->step3=$this->step4=
			$this->step5=$this->step6=$this->step7=$this->step8=
			$this->step9=$this->step10=$this->step11=$this->step12=
			$this->step13=$this->step14=$this->step15=$this->step16=
			$this->step17=$this->step18=$this->step19=$this->step20=
			$this->step21=$this->step22=$this->step23=$this->step24=
			$this->step25 = NULL;
	}
}
