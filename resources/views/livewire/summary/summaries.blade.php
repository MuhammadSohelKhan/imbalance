<div class="box">


	<div class="card">
		<div class="card-header">
			<h4 class="card-title">List of New Summaries</h4>
		</div>
		<div class="table-responsive">
			<table class="table table-vcenter card-table table-striped text-nowrap">
				<thead>
					<tr>
						<th>SL</th>
						<th>Company</th>
						<th>Buyer</th>
						<th>Style</th>
						<th>Item</th>
            <th>Study Date</th>
						<th class="w-1">Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($summaries as $summary)
					<tr>
						{{-- <td>{{ $loop->iteration }}</td> --}}
						<td>{{ $summary->id }}</td>
						<td><a href="{{ route('lines', $summary->id) }}" class="text-reset" tabindex="-1" title="Click to see Lines">{{ $summary->company }}</a></td>
						<td class="text-muted">{{ $summary->buyer }}</td>
						<td class="text-muted">{{ $summary->style }}</td>
						<td class="text-muted">{{ $summary->item }}</td>
            <td class="text-muted">{{ $summary->study_date }}</td>
            <td><a href="{{ route('lines', $summary->id) }}" class="btn btn-sm btn-info" tabindex="-1">View Lines</a></td>
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



	<div class="modal modal-blur fade" wire:ignore.self id="modal-report" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Line Imbalance Operation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModalForm">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
            </button>
          </div>


        {{-- START SUMMARY FORM --}}
          @if($currentStep == 1)
          <form id="summary-form" wire:submit.prevent="saveSummary">
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Company</label>
                  <input type="text" class="form-control" id="company" name="company" wire:model="company" placeholder="Write company name">
                  <span class="text-danger">@error('company') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Buyer</label>
                  <input type="text" class="form-control" id="buyer" name="buyer" wire:model="buyer" placeholder="Write buyer name">
                  <span class="text-danger">@error('buyer') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Style</label>
                  <input type="text" class="form-control" id="style" name="style" wire:model="style" placeholder="Write style name">
                  <span class="text-danger">@error('style') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Item</label>
                  <input type="text" class="form-control" id="item" name="item" wire:model="item" placeholder="Write item name">
                  <span class="text-danger">@error('item') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Study Date</label>
                  <input type="date" class="form-control" id="study_date" name="study_date" wire:model="study_date" placeholder="Write study date">
                  <span class="text-danger">@error('study_date') {{ $message }} @enderror</span>
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
        {{-- END SUMMARY FORM --}}


        {{-- START LINE FORM --}}
          @if($currentStep == 2)
          <form id="summary-form" wire:submit.prevent="saveLine">
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Floor</label>
                  <input type="number" class="form-control" id="floor" name="floor" wire:model="floor" placeholder="Write floor number">
                  <span class="text-danger">@error('floor') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Line</label>
                  <input type="number" class="form-control" id="line" name="line" wire:model="line" placeholder="Write line number">
                  <span class="text-danger">@error('line') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Allowance</label>
                  <input type="number" class="form-control" id="allowance" name="allowance" wire:model="allowance" placeholder="Write allowance amount">
                  <span class="text-danger">@error('allowance') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Achieved</label>
                  <input type="number" class="form-control" id="achieved" name="achieved" wire:model="achieved" placeholder="Write achieved amount">
                  <span class="text-danger">@error('achieved') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Summary ID</label>
                  <input type="number" class="form-control" id="summary_id" name="summary_id" wire:model="summary_id" disabled="true">
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
          <form id="summary-form" wire:submit.prevent="saveOperation">
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Operation Type</label>
                  <input type="text" class="form-control" id="type" name="type" wire:model="type" placeholder="Write operation type">
                  <span class="text-danger">@error('type') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Machine</label>
                  <input type="text" class="form-control" id="machine" name="machine" wire:model="machine" placeholder="Write machine name/type">
                  <span class="text-danger">@error('machine') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Allocated Manpower</label>
                  <input type="number" class="form-control" id="allocated_man_power" name="allocated_man_power" wire:model="allocated_man_power" placeholder="Write allocated man power amount">
                  <span class="text-danger">@error('allocated_man_power') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Line ID</label>
                  <input type="number" class="form-control" id="line_id" name="line_id" wire:model="line_id" disabled="true">
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
        {{-- END OPERATION FORM --}}


        {{-- START STAGEs FORM --}}
          @if($currentStep == 4)
          <form id="summary-form" wire:submit.prevent="saveStages">
          <div class="modal-body">
          	<div class="row"><h5>Operation-{{ $stageStep }}</h5></div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">First</label>
                  <input type="number" class="form-control" id="first" name="first" wire:model="first" placeholder="Write first number">
                  <span class="text-danger">@error("first") {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Second</label>
                  <input type="number" class="form-control" id="second" name="second" wire:model="second" placeholder="Write second number">
                  <span class="text-danger">@error("second") {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Third</label>
                  <input type="number" class="form-control" id="third" name="third" wire:model="third" placeholder="Write third amount">
                  <span class="text-danger">@error("third") {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Fourth</label>
                  <input type="number" class="form-control" id="fourth" name="fourth" wire:model="fourth" placeholder="Write fourth amount">
                  <span class="text-danger">@error("fourth") {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Fifth</label>
                  <input type="number" class="form-control" id="fifth" name="fifth" wire:model="fifth" placeholder="Write fifth amount">
                  <span class="text-danger">@error("fifth") {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Operation ID</label>
                  <input type="number" class="form-control" id="operation_id" name="operation_id" wire:model="operation_id" disabled="true">
                  <span class="text-danger">@error('operation_id') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-lg-4 offset-4">
                <div class="mb-3">
                  <button class="btn btn-secondary btn-sm" wire:click="addNewStage">
		            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
		            Add Another
		          </button>
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
              @if($currentStep == 4) {{ 'Finish' }} @else {{ 'Next' }} @endif
            </button>
          </div>
          </form>
          @endif
        {{-- END STAGEs FORM --}}
        </div>
      </div>
    </div>
</div>