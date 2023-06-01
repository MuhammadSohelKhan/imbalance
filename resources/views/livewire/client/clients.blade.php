<div class="box">
  <style type="text/css">
    .table thead th {
      color: #354052;
      background-color: #D8E4BC;
    }

    .link-secondary {
        color: #b0bca2;
    }

    .link-secondary:hover {
        color: #addafb;
    }
  </style>

  <div>
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <ul>
            <li>{{ session()->get('success') }}</li>
        </ul>
        <a href="#" class="pt-3 close" data-dismiss="alert" aria-label="close" style="font-size: 2rem;">&times;</a>
    </div>
    @endif
    @if (session()->has('fail'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul>
            <li>{{ session()->get('fail') }}</li>
        </ul>
        <a href="#" class="pt-3 close" data-dismiss="alert" aria-label="close" style="font-size: 2rem;">&times;</a>
    </div>
    @endif
  </div>

	<div class="card">
    <div class="card-header justify-content-between">
      <h4 class="card-title">All Clients</h4>

      @if(in_array($aUser->role, ['Master','superadmin','admin','CiC']))
      <a href="{{ route('users.all') }}" class="btn btn-sm btn-secondary" title="See all users">Users</a>
      @endif
    </div>
		<div class="table-responsive">
			<table class="table table-vcenter card-table table-striped text-nowrap">
				<thead>
					<tr>
						<th>SL</th>
						<th>Company Name</th>
						<th>Client Code</th>
						<th>Status</th>
						<th>Owner</th>
						<th>Total Factories</th>
            <th>Head Office</th>
            <th>Established</th>
            <th class="w-1">Actions</th>
					</tr>
				</thead>
				<tbody>
					@forelse($clients as $client)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $client->name }}</td>
						<td><a href="{{ route('lines', $client->id) }}" class="text-reset" tabindex="-1">{{ $client->client_code }}</a></td>
						<td>
              @if($client->is_active) 
                <span class="btn-sm bg-green text-white">Active</span>
              @else 
                <span class="btn-sm bg-red text-white">Inactive</span> 
              @endif
            </td>
						<td>{{ $client->owner }}</td>
						<td>{{ $client->total_factories }}</td>
						<td>{{ $client->head_office }}</td>
            <td>{{ $client->estd_date }}</td>
            <td><a href="{{ route('projects', $client->id) }}" class="btn btn-sm btn-info" tabindex="-1" title="See projects of this client">View Projects</a>
              @if(in_array($aUser->role, ['Master','superadmin','admin']))
                <a href="#" data-toggle="modal" data-target="#modal-client-operation" wire:click="editClient({{ $client->id }}, '{{ $client->name }}', '{{ $client->client_code }}', '{{ $client->head_office }}', '{{ $client->total_factories }}', '{{ $client->owner }}', '{{ $client->estd_date }}', '{{ $client->is_active }}')" class="btn btn-sm btn-warning" tabindex="-1" title="Edit this client details">Edit</a>
                @if($aUser->role != 'admin')
                <a href="#" wire:dblclick="deleteClient({{ $client->id }})" class="btn btn-sm btn-danger" tabindex="-1" title="Double click to delete this client">Delete</a>
                @endif
              @endif
            </td>
					</tr>
					@empty
					<tr>
            <td colspan="9" class="text-center">No data found.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>



  @if($aUser->role != 'viewer')
	<div class="modal modal-blur fade" wire:ignore.self id="modal-client-operation" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content border-white">
        <div class="modal-header">
          <h5 class="modal-title">{{ $formStatus }} Client Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModalForm">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
          </button>
        </div>
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <ul>
                <li>{{ session()->get('success') }}</li>
            </ul>
            <a href="#" class="pt-3 close" data-dismiss="alert" aria-label="close" style="font-size: 2rem;">&times;</a>
        </div>
        @endif
        @if (session()->has('fail'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <ul>
                <li>{{ session()->get('fail') }}</li>
            </ul>
            <a href="#" class="pt-3 close" data-dismiss="alert" aria-label="close" style="font-size: 2rem;">&times;</a>
        </div>
        @endif


        {{-- START CLIENT FORM --}}
          <form id="client-form" wire:submit.prevent="saveClient">
            @if($formStatus === 'Update')
              <input type="hidden" wire:model="clID">
            @endif
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Company Name</label>
                  <input type="text" class="form-control" id="name" name="name" wire:model.lazy="name" placeholder="Write company name of the client">
                  <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Client Code</label>
                  <input type="text" class="form-control" id="client_code" name="client_code" wire:model.lazy="client_code" placeholder="Write client code here">
                  <span class="text-danger">@error('client_code') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Owner</label>
                  <input type="text" class="form-control" id="owner" name="owner" wire:model.lazy="owner" placeholder="Write company owner's name">
                  <span class="text-danger">@error('owner') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Head Office</label>
                  <input type="text" class="form-control" id="head_office" name="head_office" wire:model.lazy="head_office" placeholder="Write head office address">
                  <span class="text-danger">@error('head_office') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Total Factories</label>
                  <input type="number" class="form-control" id="total_factories" name="total_factories" wire:model.lazy="total_factories" placeholder="Write the number of total factories">
                  <span class="text-danger">@error('total_factories') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Establishment Date</label>
                  <input type="date" class="form-control" id="estd_date" name="estd_date" wire:model.lazy="estd_date" placeholder="Write the date of establishment">
                  <span class="text-danger">@error('estd_date') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <div class="form-label text-capitalize">{{ __('Active Client?') }}</div>
                  <label style="max-width: 13%;" for="is_active" class="form-check form-switch">
                    <input id="is_active" name="is_active" class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" wire:model.lazy="is_active" @if(old('is_active')) checked @endif>
                  </label>

                  @error('is_active')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="reset" class="btn btn-link link-secondary" data-dismiss="modal" wire:click="resetModalForm">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Save
            </button>
          </div>
          </form>
        {{-- END CLIENT FORM --}}
      </div>
    </div>
  </div>
  @endif
</div>