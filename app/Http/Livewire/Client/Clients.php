<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

use App\Models\Client;
use App\Models\Project;

class Clients extends Component
{
    public $aUser;
    public $formStatus = 'Add New';
	public $clID, $name, $client_code, $head_office, $total_factories, $owner, $estd_date, $is_active = FALSE;

    public function render()
    {
        if (! $this->aUser) {
            abort(403);
        }

        $this->dispatchBrowserEvent('refreshJSVariables');
    	$clients = Client::orderBy('is_active', 'desc')->orderBy('name', 'asc');
        if (in_array($this->aUser->role,['CiC','user','viewer'])) {
            $clients = $clients->where('id',$this->aUser->client_id);
        }
        $clients = $clients->get();
        return view('livewire.client.clients', compact('clients'));
    }

    public function resetModalForm()
    {
    	$this->resetErrorBag();
    	$this->resetAllPublicVariables();
    }

    public function saveClient()
    {
        if ($this->aUser->role == 'viewer') abort(403);

        if (in_array($this->aUser->role, ['Master','superadmin','admin'])) {
            $clientData = $this->validate([
                'name' => 'required|string|max:100|unique:clients,name,'.$this->clID,
                'client_code' => 'required|string|regex:/^CL-[A-Z]{2}-(?!000)\d{3}$/|unique:clients,client_code,'.$this->clID,
                'head_office' => 'nullable|string|max:500',
                'total_factories' => 'nullable|integer|min:1',
                'owner' => 'nullable|string|max:100',
                'estd_date' => 'nullable|date|before:tomorrow',
                'is_active' => 'required|boolean',
            ]);


            if ($this->formStatus === 'Update') {
                $this->validate(['clID' => 'required|exists:clients,id']);
                $clientData['estd_date'] = ($clientData['estd_date']) ? $clientData['estd_date'] : NULL;

                $client = Client::where('id', $this->clID)->first();
                $clIsActive = $client->is_active;
                $createdClient = $client->update($clientData);

                if ($createdClient && $clIsActive && !$clientData['is_active']) {
                    Project::where('client_id', $client->id)->update(['is_active' => 0]);
                }
            } else {
                $createdClient = Client::create($clientData);
            }

            if ($createdClient) {
                $this->resetAllPublicVariables();
                session()->flash('success', 'Data saved successfully.');
            } else {
                session()->flash('fail', 'Unable to save.');
            }
        } else {
            session()->flash('fail', 'You don\'t have access to do this.');
        }
    }

    public function editClient($id, $name, $client_code, $head_office, $total_factories, $owner, $estd_date, $is_active)
    {
        if ($this->aUser->role == 'viewer') abort(403);

        if (in_array($this->aUser->role, ['Master','superadmin','admin'])) {
            $this->clID = $id;
            $this->name = $name;
            $this->client_code = $client_code;
            $this->head_office = $head_office;
            $this->total_factories = $total_factories;
            $this->owner = $owner;
            $this->estd_date = $estd_date;
            $this->is_active = ($is_active) ? TRUE : FALSE;

            $this->formStatus = 'Update';
        } else {
            session()->flash('fail', 'You don\'t have access to do this.');
        }
    }

    public function deleteClient($id)
    {
        if ($this->aUser->role == 'viewer') abort(403);

        if (in_array($this->aUser->role, ['Master','superadmin'])) {
            $deletedClient = Client::where('id', $id)->first()->delete();
            if ($deletedClient) {
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

        # Client variables
        $this->clID = null;
    	$this->name = null;
		$this->client_code = null;
		$this->head_office = null;
		$this->total_factories = null;
        $this->estd_date = null;
        $this->owner = null;
		$this->is_active = FALSE;
    }
}