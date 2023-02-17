<div class="box">

  <style type="text/css">
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
  </style>


	<div class="card">
		<div class="card-header justify-content-between">
			<h4 class="card-title">Analytics of Lines</h4>
      		<a href="{{ route('home') }}" class="btn btn-sm btn-secondary">Back</a>
		</div>
		<div class="table-responsive">
			<table class="table table-vcenter card-table table-striped text-nowrap">
				<thead>
					<tr>
						<th>SL</th>
						<th>Floor</th>
						<th>Line</th>
						<th>Allowance</th>
						<th>Possible Output</th>
						<th>Actual Production</th>
						<th>Improve Scope/hr</th>
						<th class="w-1">Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($lines as $line)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $line->floor }}</td>
						<td class="text-muted">{{ $line->line }}</td>
						<td class="text-muted">{{ $line->allowance }}</td>
						<td class="text-muted">{{ $line->possible_output }}</td>
						<td class="text-muted">{{ $line->achieved }}</td>
						<td class="text-muted">{{ $line->possible_output - $line->achieved }}</td>
						<td><a href="{{ route('operations', $line->id) }}" class="btn btn-sm btn-info" tabindex="-1">View Details</a></td>
					</tr>
					@empty
					<tr>
            			<td colspan="6" class="text-center">No data found.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>




	<div class="modal modal-blur fade" wire:ignore.self id="modal-line-operation" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Line Operation</h5>
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
          @if($currentStep == 2)
          <form id="summary-form" wire:submit.prevent="saveLine">
          <div class="modal-body">
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
                  <label class="form-label">Summary ID</label>
                  <input type="number" class="form-control" id="summary_id" name="summary_id" wire:model.lazy="summary_id" disabled="true">
                  <span class="text-danger">@error('summary_id') {{ $message }} @enderror</span>
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
          @endif
        {{-- END LINE FORM --}}


        {{-- START OPERATION FORM --}}
          @if($currentStep == 3)
          <form id="summary-form" wire:submit.prevent="saveOperation(Object.fromEntries(new FormData($event.target)))">
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
                <label class="mb-2 mt-4">
                  <input class="form-check-input" type="checkbox" id="keep_data" wire:model.lazy="keep_data" checked="true">
                  <span class="form-check-label"> Keep these data</span>
                </label>
          </div>
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
          @endif
        {{-- END OPERATION FORM --}}


        {{-- START STAGEs FORM --}}
          @if($currentStep == 4)
          <form id="summary-form" wire:submit.prevent="saveLine">
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">First</label>
                  <input type="number" class="form-control" id="first" name="first" wire:model.lazy="first" placeholder="Write first number">
                  <span class="text-danger">@error('first') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Second</label>
                  <input type="number" class="form-control" id="second" name="second" wire:model.lazy="second" placeholder="Write second number">
                  <span class="text-danger">@error('second') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Third</label>
                  <input type="number" class="form-control" id="third" name="third" wire:model.lazy="third" placeholder="Write third amount">
                  <span class="text-danger">@error('third') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Fourth</label>
                  <input type="number" class="form-control" id="fourth" name="fourth" wire:model.lazy="fourth" placeholder="Write fourth amount">
                  <span class="text-danger">@error('fourth') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Fifth</label>
                  <input type="number" class="form-control" id="fifth" name="fifth" wire:model.lazy="fifth" placeholder="Write fifth amount">
                  <span class="text-danger">@error('fifth') {{ $message }} @enderror</span>
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
          @endif
        {{-- END STAGEs FORM --}}
        </div>
      </div>
    </div>
</div>
