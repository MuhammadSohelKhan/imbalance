<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;

use App\Models\Project;

class Projects extends Component
{
    public $aUser;
    public $formStatus = 'Add New';
    public $projID, $start_date, $renew_date, $end_date, $assigned_officer, $is_active = FALSE, $present_situation, $goal, $client_id, $client;

    public function render()
    {
        if (! $this->aUser) {
            abort(403);
        }

        $projects = Project::where('client_id', $this->client_id)->orderBy('is_active', 'desc')->orderBy('id', 'desc')->get();
        return view('livewire.project.projects', compact('projects'));
    }

    public function resetModalForm()
    {
        $this->resetErrorBag();
        $this->resetAllPublicVariables();
    }

    public function saveProject()
    {
        if (in_array($this->aUser->role, ['Master','superadmin','admin'])) {
            $projectData = $this->validate([
                'start_date' => 'required|date',
                'renew_date' => 'nullable|date|after:start_date',
                'end_date' => 'required|date|after:start_date',
                'assigned_officer' => 'nullable|string|max:100',
                'is_active' => 'required|boolean',
                'present_situation' => 'nullable|string|max:1500',
                'goal' => 'nullable|string|max:1500',
                'client_id' => 'required|exists:clients,id',
            ]);


            if ($this->formStatus === 'Update') {
                $this->validate(['projID' => 'required|exists:projects,id']);
                $projectData['renew_date'] = ($projectData['renew_date']) ? $projectData['renew_date'] : NULL;

                $createdProject = Project::where('id', $this->projID)->first()->update($projectData);
            } else {
                $createdProject = Project::create($projectData);
            }

            if ($createdProject) {
                $this->resetAllPublicVariables();
                session()->flash('success', 'Data saved successfully.');
            } else {
                session()->flash('fail', 'Unable to save.');
            }
        } else {
            session()->flash('fail', 'You don\'t have access to do this.');
        }
    }

    public function editProject($id, $start_date, $renew_date, $end_date, $assigned_officer, $is_active, $present_situation, $goal)
    {
        if (in_array($this->aUser->role, ['Master','superadmin','admin'])) {
            $this->projID = $id;
            $this->start_date = $start_date;
            $this->renew_date = $renew_date;
            $this->end_date = $end_date;
            $this->assigned_officer = $assigned_officer;
            $this->is_active = ($is_active) ? TRUE : FALSE;
            $this->present_situation = $present_situation;
            $this->goal = $goal;

            $this->formStatus = 'Update';
        } else {
            session()->flash('fail', 'You don\'t have access to do this.');
        }
    }

    public function deleteProject($id)
    {
        if (in_array($this->aUser->role, ['Master','superadmin','admin'])) {
            $deletedProject = Project::where('id', $id)->first()->delete();
            if ($deletedProject) {
                session()->flash('success', 'Data deleted successfully.');
            }
        } else {
            session()->flash('fail', 'You don\'t have access to do this.');
        }
    }

    public function resetAllPublicVariables()
    {
        # Other Variables
        $this->formStatus = 'Add New';

        # Project variables
        $this->projID = null;
        $this->start_date = null;
        $this->renew_date = null;
        $this->end_date = null;
        $this->assigned_officer = null;
        $this->is_active = FALSE;
        $this->present_situation = null;
        $this->goal = null;
    }
}