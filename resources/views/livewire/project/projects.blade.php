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
			<h4 class="card-title">Projects of {{ $client->name }}</h4>
      <a href="{{ route('home') }}" class="btn btn-sm btn-secondary">Back</a>
		</div>
		<div class="table-responsive">
			<table class="table table-vcenter card-table table-striped text-nowrap">
				<thead>
					<tr>
						<th>ID</th>
						<th>Start Date</th>
						<th>Renew Date</th>
						<th>End Date</th>
						<th>Status</th>
						<th>Assigned Officer</th>
            <th class="w-1">Actions</th>
					</tr>
				</thead>
				<tbody>
					@forelse($projects as $project)
					<tr>
						<td>{{ $project->id }}</td>
						<td>{{ $project->start_date }}</td>
						<td>{{ $project->renew_date }}</td>
						<td>{{ $project->end_date }}</td>
						<td>
              @if($project->is_active) 
                <span class="btn-sm bg-green text-white">Active</span>
              @else 
                <span class="btn-sm bg-red text-white">Inactive</span> 
              @endif
            </td>
						<td>{{ $project->assigned_officer }}</td>
            <td><a href="{{ route('lines', $project->id) }}" class="btn btn-sm btn-info" tabindex="-1" title="See lines of this project">View Lines</a>
              <a href="{{ route('summary.export', $project->id) }}" class="btn btn-sm btn-info" tabindex="-1" title="Download imbalance summary of this project">Download</a>

              @if(in_array($aUser->role, ['Master','superadmin','admin','CiC'])) 
                <a href="#" data-toggle="modal" data-target="#modal-project-operation" wire:click="editProject({{ $project->id }}, '{{ $project->start_date }}', '{{ $project->renew_date }}', '{{ $project->end_date }}', '{{ $project->assigned_officer }}', {{ $project->is_active }}, '{{ $project->present_situation }}', '{{ $project->goal }}')" class="btn btn-sm btn-warning" tabindex="-1" title="Edit this project details">Edit</a>
                @if($aUser->role != 'CiC')
                <a href="#" wire:dblclick="deleteProject({{ $project->id }})" class="btn btn-sm btn-danger" tabindex="-1" title="Double click to delete this project">Delete</a>
                @endif
              @endif
            </td>
					</tr>
					@empty
					<tr>
            <td colspan="7" class="text-center">No data found.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>



  @if($aUser->role != 'viewer')
	<div class="modal modal-blur fade" wire:ignore.self id="modal-project-operation" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-white">
          <div class="modal-header">
            <h5 class="modal-title">
              {{ $formStatus }} Project Details
            </h5>
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


        {{-- START PROJECT FORM --}}
          <form id="projcet-form" wire:submit.prevent="saveProject">
            <input type="hidden" wire:model="client_id">
            @if($formStatus === 'Update')
              <input type="hidden" wire:model="projID">
            @endif
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Start Date</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" wire:model.lazy="start_date" placeholder="Write the date of establishment">
                  <span class="text-danger">@error('start_date') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Renew Date</label>
                  <input type="date" class="form-control" id="renew_date" name="renew_date" wire:model.lazy="renew_date" placeholder="Write the date of establishment">
                  <span class="text-danger">@error('renew_date') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">End Date</label>
                  <input type="date" class="form-control" id="end_date" name="end_date" wire:model.lazy="end_date" placeholder="Write the date of establishment">
                  <span class="text-danger">@error('end_date') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Assigned Officer</label>
                  <input type="text" class="form-control" id="assigned_officer" name="assigned_officer" wire:model.lazy="assigned_officer" placeholder="Write head office address">
                  <span class="text-danger">@error('assigned_officer') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Present Situation</label>
                  <textarea class="form-control" id="present_situation" name="present_situation" wire:model.lazy="present_situation" placeholder="Write the present condition of the company"></textarea>
                  <span class="text-danger">@error('present_situation') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Our Goal</label>
                  <textarea class="form-control" id="goal" name="goal" wire:model.lazy="goal" placeholder="Write the present condition of the company"></textarea>
                  <span class="text-danger">@error('goal') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>

            @if($client->is_active)
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <div class="form-label text-capitalize">{{ __('Running Project?') }}</div>
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
            @endif
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
        {{-- END PROJECT FORM --}}
      </div>
    </div>
  </div>
  @endif
</div>