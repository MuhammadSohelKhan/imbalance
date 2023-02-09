<div class="box">


	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Analytics of Summaries will be added here</h4>
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
						<th class="w-1">Study Date</th>
					</tr>
				</thead>
				<tbody>
					@forelse($summaries as $summary)
					<tr>
						{{-- <td>{{ $loop->iteration }}</td> --}}
						<td>{{ $summary->id }}</td>
						<td><a href="#" class="text-reset" tabindex="-1">{{ $summary->company }}</a></td>
						<td class="text-muted">{{ $summary->buyer }}</td>
						<td class="text-muted">{{ $summary->style }}</td>
						<td class="text-muted">{{ $summary->item }}</td>
						<td class="text-muted">{{ $summary->study_date }}</td>
					</tr>
					@empty
					<tr>
						<td><a href="#" class="text-reset" tabindex="-1">Panacea Private Consulting Group</a></td>
						<td class="text-muted">Target</td>
						<td class="text-muted">Cb-101</td>
						<td class="text-muted">Shirt</td>
						<td class="text-muted">07 May 2020</td>
					</tr>
					<tr>
						<td><a href="#" class="text-reset" tabindex="-1">Panacea Private Consulting Group</a></td>
						<td class="text-muted">Target</td>
						<td class="text-muted">Cb-101</td>
						<td class="text-muted">Shirt</td>
						<td class="text-muted">07 May 2020</td>
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
        </div>
      </div>
    </div>
</div>
