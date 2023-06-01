<div class="box">

	<style type="text/css">
		.table thead th {
			color: #354052;
			background-color: #D8E4BC;
		}

		#operation1, #operation2, #operation3, #operation4, #operation5 {
			position: relative;
		}

		#stageDiv1, #stageDiv2, #stageDiv3, #stageDiv4, #stageDiv5 {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 100;
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
			<h4 class="card-title">Edit {{($newLine->copied_from)?'Copied':''}} Line</h4>
			<a href="{{ route('lines', $newLine->project_id) }}" class="btn btn-sm btn-secondary">Back</a>
		</div>
		<div class="table-responsive">
			<table class="table table-vcenter card-table table-striped text-nowrap table-bordered text-center">
				<thead>
					<tr>
						<th>Buyer</th>
						<th>Style</th>
						<th>Item</th>
						<th>Study Date</th>
						<th>Floor</th>
						<th>Line</th>
						<th>Allowance</th>
						<th>Actual Production</th>
						<th class="w-1">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ $newLine->buyer ?? '' }}</td>
						<td>{{ $newLine->style ?? '' }}</td>
						<td>{{ $newLine->item ?? '' }}</td>
						<td>{{ $newLine->study_date ?? '' }}</td>
						<td>Fl-{{ $newLine->floor ?? '' }}</td>
						<td>Ln-{{ $newLine->line ?? '' }}</td>
						<td>{{ $newLine->allowance ?? '' }}</td>
						<td>{{ $newLine->achieved ?? '' }}</td>
						<td>
              @if($aUser->role != 'viewer')
              <a href="#" data-toggle="modal" data-target="#modal-line-operation" class="btn btn-sm btn-warning" tabindex="-1" title="Edit this line">Edit</a>
						  <a href="#" wire:dblclick="deleteLine()" class="btn btn-sm btn-danger" tabindex="-1" title="Double click to delete this line">Delete</a>
              @endif
            </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<hr>

	<div class="card">
		<div class="card-header justify-content-between">
			<h4 class="card-title">Operations of this Line</h4>
      <a href="{{ route('operations', $newLine->id) }}" class="btn btn-sm btn-primary">Add New</a>
		</div>
		<div class="table-responsive">
			<table class="table table-vcenter card-table table-striped text-nowrap table-bordered text-center">
				<thead>
					<tr>
						<th>SL</th>
						<th>Operation</th>
						<th>Machine</th>
						<th>Avg Cycle Time</th>
						<th>Cycle Time With Allowance</th>
						<th>Allocated MP</th>
						<th class="w-1">Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($newLine->operations as $index => $opr)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $opr->type ?? '' }}</td>
						<td>{{ $opr->machine ?? '' }}</td>
						<td>{{ $opr->average_cycle_time ?? '' }}</td>
						<td>{{ $opr->cycle_time_with_allowance ?? '' }}</td>
						<td>{{ $opr->allocated_man_power ?? '' }}</td>
						<td>
              @if($aUser->role != 'viewer')
              <a href="#" data-toggle="modal" data-target="#modal-operations" wire:click="editOpr({{ $index }})" class="btn btn-sm btn-warning" tabindex="-1" title="Edit this operation">Edit</a>
						  <button wire:dblclick="deleteOpr({{ $index }})" class="btn btn-sm btn-danger" tabindex="-1" title="Double click to delete this operation">Delete</button>
              @endif
            </td>
					</tr>
					@empty
					<tr>
						<td colspan="7">No data found.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>



  @if($aUser->role != 'viewer')
	<div class="modal modal-blur fade" wire:ignore.self id="modal-line-operation" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-white">
          <div class="modal-header">
            <h5 class="modal-title">Edit {{($newLine->copied_from)?'Copied':''}} Line</h5>
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


        {{-- START LINE FORM --}}
          <form id="project-form" wire:submit.prevent="updateLine">
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Buyer</label>
                  <input type="text" class="form-control" id="buyer" name="buyer" wire:model.lazy="buyer" placeholder="Write buyer name">
                  <span class="text-danger">@error('buyer') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Style</label>
                  <input type="text" class="form-control" id="style" name="style" wire:model.lazy="style" placeholder="Write style of the product">
                  <span class="text-danger">@error('style') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Item</label>
                  <input type="text" class="form-control" id="item" name="item" wire:model.lazy="item" placeholder="Write item name">
                  <span class="text-danger">@error('item') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Study Date</label>
                  <input type="date" class="form-control" id="study_date" name="study_date" wire:model.lazy="study_date" placeholder="Write study date">
                  <span class="text-danger">@error('study_date') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Floor</label>
                  <input type="number" class="form-control" id="floor" name="floor" wire:model.lazy="floor" placeholder="Write floor number">
                  <span class="text-danger">@error('floor') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Line</label>
                  <input type="number" class="form-control" id="line" name="line" wire:model.lazy="line" placeholder="Write line number">
                  <span class="text-danger">@error('line') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Allowance</label>
                  <input type="number" class="form-control" id="allowance" name="allowance" wire:model.lazy="allowance" placeholder="Write allowance amount">
                  <span class="text-danger">@error('allowance') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Achieved</label>
                  <input type="number" class="form-control" id="achieved" name="achieved" wire:model.lazy="achieved" placeholder="Write achieved amount">
                  <span class="text-danger">@error('achieved') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Project ID</label>
                  <input type="number" class="form-control" id="project_id" name="project_id" wire:model.lazy="project_id" disabled="true">
                  <span class="text-danger">@error('project_id') {{ $message }} @enderror</span>
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
              Next
            </button>
          </div>
          </form>
        {{-- END LINE FORM --}}
        </div>
      </div>
    </div>




	<div class="modal modal-blur fade" wire:ignore.self id="modal-operations" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-white">
          <div class="modal-header">
            <h5 class="modal-title">Edit Operation</h5>
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


        {{-- START OPERATION FORM --}}
          <form id="project-form" wire:submit.prevent="updateOperation(Object.fromEntries(new FormData($event.target)))">
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Operation Type</label>
                  <input type="text" class="form-control" id="type" wire:model.lazy="type" placeholder="Write operation type">
                  <span class="text-danger">@error('type') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Machine</label>
                  <input type="text" class="form-control" id="machine" wire:model.lazy="machine" placeholder="Write machine name/type">
                  <span class="text-danger">@error('machine') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Allocated Manpower</label>
                  <input type="number" class="form-control" id="allocated_man_power" wire:model.lazy="allocated_man_power" placeholder="Write allocated man power amount">
                  <span class="text-danger">@error('allocated_man_power') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Line ID</label>
                  <input type="number" class="form-control" id="line_id" name="line_id" wire:model.lazy="line_id" disabled="true">
                  <span class="text-danger">@error('line_id') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
                {{-- <label class="mb-2 mt-4">
                  <input class="form-check-input" type="checkbox" id="keep_data" wire:model.lazy="keep_data" checked="true">
                  <span class="form-check-label"> Keep these data</span>
                </label> --}}
          </div>

          @if($editStage)
          @php $s=0; @endphp
          @foreach($toUpdateOpr->stages as $k => $val) 
          <div id="operation{{$k+1}}" class="modal-body">
            <div class="row">
              <h3 class="text-muted">Operation-{{$k+1}}</h3>
            </div>
            <div id="stage{{$k+1}}" class="row offset-1">
              <div id="stageDiv{{$k+1}}" class="d-flex align-items-center justify-content-end px-6">
                @if($k && ($k+1) == sizeof($toUpdateOpr->stages))<a href="#" class="btn btn-sm btn-danger mt-4" wire:click="deleteStage({{$k}})">X</a>@endif
              </div>
              {{-- <div id="stageDiv{{$k+1}}"></div> --}}
              <div class="col-2 px-1">
                <input id="step{{$s+1}}" name="step{{$s+1}}" wire:model.lazy="step{{$s+1}}" class="w-100" type="number" required>
              </div>
              <div class="col-2 px-1">
                <input id="step{{$s+2}}" name="step{{$s+2}}" wire:model.lazy="step{{$s+2}}" class="w-100" type="number" required>
              </div>
              <div class="col-2 px-1">
                <input id="step{{$s+3}}" name="step{{$s+3}}" wire:model.lazy="step{{$s+3}}" class="w-100" type="number" required>
              </div>
              <div class="col-2 px-1">
                <input id="step{{$s+4}}" name="step{{$s+4}}" wire:model.lazy="step{{$s+4}}" class="w-100" type="number" required>
              </div>
              <div class="col-2 px-1">
                <input id="step{{$s+5}}" name="step{{$s+5}}" wire:model.lazy="step{{$s+5}}" class="w-100" type="number" required>
              </div>
            </div>
          </div>
          @php $s+=5; @endphp
          @endforeach
          <div class="modal-body">
            <div class="row">
              <h1 id="showTimer" class="col-4 offset-4 text-center">00:00</h1>
            </div>
            <a id="playTimer" class="col-2 offset-5 text-white btn btn-warning" onclick="event.preventDefault(); startTimer(this);">Play</a>
          </div>
          @else
          <div id="operation1" class="modal-body">
          	<div class="row">
          		<h3 class="text-muted">Operation-1</h3>
          	</div>
          	<div id="stage1" class="row offset-1">
              <div id="stageDiv1"></div>
          		<div class="col-2 px-1">
          			<input id="step1" name="step1" wire:model.lazy="step1" class="w-100" type="number" required>
          		</div>
          		<div class="col-2 px-1">
          			<input id="step2" name="step2" wire:model.lazy="step2" class="w-100" type="number" required>
          		</div>
          		<div class="col-2 px-1">
          			<input id="step3" name="step3" wire:model.lazy="step3" class="w-100" type="number" required>
          		</div>
          		<div class="col-2 px-1">
          			<input id="step4" name="step4" wire:model.lazy="step4" class="w-100" type="number" required>
          		</div>
          		<div class="col-2 px-1">
          			<input id="step5" name="step5" wire:model.lazy="step5" class="w-100" type="number" required>
          		</div>
          	</div>
          </div>
          <div class="modal-body">
          	<div class="row">
          		<h1 id="showTimer" class="col-4 offset-4 text-center">00:00</h1>
          	</div>
          	<a id="playTimer" class="col-2 offset-5 text-white btn btn-warning" onclick="event.preventDefault(); startTimer(this);">Play</a>
          </div>
          @endif

          <div class="modal-footer">
            <button type="reset" class="btn btn-link link-secondary" data-dismiss="modal" wire:click="resetModalForm">
              Cancel
            </button>
            <button id="submitBtn" type="submit" class="btn btn-primary ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Next
            </button>
          </div>
          </form>
        {{-- END OPERATION FORM --}}
        </div>
      </div>
  </div>
  @endif
</div>
