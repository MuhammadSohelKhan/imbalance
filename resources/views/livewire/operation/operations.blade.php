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
			<h4 class="card-title">Analysis of Line-{{ $line->line }}</h4>
      		<a href="{{ route('lines', $summary->id) }}" class="btn btn-sm btn-secondary">Back</a>
		</div>
		<div class="table-responsive">
			<table class="table table-vcenter card-table table-striped table-bordered text-center">
				<thead>
					<tr style="background-color: #b7dee8;">
						<th colspan="9" style="font-size: 1.2rem; font-weight: bolder;">Imbalance check <br>{{ $summary->company }}</th>
						<th style="font-size: 1.2rem; vertical-align: middle; background-color: #FABF8F; padding-right: .5rem;"><a href="{{ route('lines', $summary->id) }}"><u>Back</u></a></th>
					</tr>
					<tr>
						<th colspan="2">Buyer</th>
						<th>{{ $summary->buyer }}</th>

						<th style="border-bottom-color: #fff;"></th>
						<th>Floor</th>
						<th>{{ $line->floor }}</th>
						<th style="border-bottom-color: #fff;"></th>
						<th colspan="2">Possible Output</th>
						<th>{{ round($operations->min('capacity_per_hour')) }}</th>
					</tr>
					<tr>
						<th colspan="2">Style</th>
						<th>{{ $summary->style }}</th>

						<th style="border-bottom-color: #fff;"></th>
						<th>Line</th>
						<th>{{ $line->line }}</th>
						<th style="border-bottom-color: #fff;"></th>
						<th colspan="2">Achieved</th>
						<th>{{ $line->achieved }}</th>
					</tr>
					<tr>
						<th colspan="2">Item</th>
						<th>{{ $summary->item }}</th>

						<th style="border-bottom-color: #fff;"></th>
						<th>Study Date</th>
						<th>{{ $summary->study_date }}</th>
						<th style="border-bottom-color: #fff;"></th>
						<th colspan="2">Imbalance</th>
						<th id="imbalanceCell"></th>
					</tr>
					<tr>
						<th colspan="2"></th>
						<th></th>

						<th></th>
						<th>Allowance</th>
						<th>{{ $line->allowance }}%</th>
						<th></th>
						<th colspan="2">Balance</th>
						<th id="balanceCell"></th>
					</tr>
				</thead>
				<thead>
					<tr>
						<th style="background-color: #b7dee8;">SL</th>
						<th style="background-color: #b7dee8;">Type</th>
						<th style="background-color: #b7dee8;">Machine</th>
						<th style="background-color: #b7dee8;">Avg Cycle Time</th>
						<th style="background-color: #b7dee8;">Cycle Time With Allowance</th>
						<th style="background-color: #b7dee8;">Allocated MP</th>
						<th style="background-color: #b7dee8;">Dedicated Cycle Time</th>
						<th style="background-color: #b7dee8;">Capacity Per Hour</th>
						<th style="background-color: #b7dee8;">Possible Output</th>
						<th style="background-color: #b7dee8;">Minutes Lost Per Hour</th>

						<th class="px-4" style="border-bottom-color: #fff;"></th>

						@for($s=1;$s<=$operations->max('stages_count');$s++)
						<th class="w-1" colspan="5">Operation-{{ $s }}</th>
						@endfor
					</tr>
				</thead>
				<tbody class=" text-nowrap">
					@php 
					$totalLostMin = 0;
					$minCapacity = $operations->min('capacity_per_hour'); 
					$totalMP = $operations->sum('allocated_man_power'); 
					@endphp
					@forelse($operations as $operation)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $operation->type }}</td>
						<td>{{ $operation->machine }}</td>
						<td>{{ $operation->average_cycle_time }}</td>
						<td>{{ round($operation->cycle_time_with_allowance, 3) }}</td>
						<td>{{ $operation->allocated_man_power }}</td>
						<td>{{ round($operation->dedicated_cycle_time, 2) }}</td>
						<td @if($operation->capacity_per_hour == $minCapacity) style="background-color: #ffc7ce;" @endif>{{ round($operation->capacity_per_hour) }}</td>
						<td>{{ round($minCapacity) ?? '' }}</td>
						@php 
						$capDiff = ($operation->capacity_per_hour - $minCapacity) * $operation->cycle_time_with_allowance;
						$totalLostMin += $capDiff;
						@endphp
						<td>{{ round($capDiff) }}</td>

						<td class="px-4" style="border-top-color: #fff; border-bottom-color: #fff;"></td>

						@forelse($operation->stages as $stage)
						<td class="text-muted" style="background-color: #CCC0DA;">{{ $stage->first }}</td>
						<td class="text-muted" style="background-color: #CCC0DA;">{{ $stage->second }}</td>
						<td class="text-muted" style="background-color: #CCC0DA;">{{ $stage->third }}</td>
						<td class="text-muted" style="background-color: #CCC0DA;">{{ $stage->fourth }}</td>
						<td class="text-muted" style="background-color: #CCC0DA;">{{ $stage->fifth }}</td>
						@empty
						<td colspan="5" style="//background-color: #CCC0DA;"></td>
						@endforelse
					</tr>
					@empty
					<tr>
            			<td colspan="10" class="text-center">No data found.</td>
					</tr>
					@endforelse
				</tbody>
				<tfoot style="font-weight: bolder;">
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>{{ $totalMP }}</td>
						<td></td>
						<td>{{ round($operations->avg('capacity_per_hour')) }}</td>
						<td>{{ round($minCapacity) }}</td>
						<td>{{ round($totalLostMin) }}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

	@if(count($operations))
	@php
	$imbalance = $totalLostMin / ($totalMP * 60);
	$balance = 1 - $imbalance;
	@endphp

	<script type="text/javascript">
		document.getElementById('imbalanceCell').innerHTML = {{ round($imbalance * 100)}}+'%';
		document.getElementById('balanceCell').innerHTML = {{ round($balance * 100) }}+'%';
	</script>
	@endif


	<div class="modal modal-blur fade" wire:ignore.self id="modal-operation" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
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


        </div>
      </div>
    </div>


	{{-- Capacity Graph --}}
	<div class="card">
		<div class="card-body">
			<h3 class="card-title text-center">Capacity Graph</h3>
			<div id="chart-capacity-overview"></div>
		</div>
	</div>
	{{-- Capacity Graph --}}



    <script type="text/javascript" src="{{ asset('dist/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('chart-capacity-overview'), {
      		chart: {
      			type: "bar",
      			fontFamily: 'inherit',
      			height: 320,
      			parentHeightOffset: 0,
      			toolbar: {
      				show: false,
      			},
      			animations: {
      				enabled: true
      			},
      		},
      		plotOptions: {
      			bar: {
      				columnWidth: '50%',
      			}
      		},
      		dataLabels: {
      			enabled: false,
      		},
      		fill: {
      			opacity: 1,
      		},
      		series: [{
      			name: "Capacity/hr",
      			data: [@foreach($operations as $opr) {{ round($opr->capacity_per_hour) ?? 0 }}, @endforeach]
      		}],
      		grid: {
      			padding: {
      				top: -20,
      				right: 0,
      				left: -4,
      				bottom: -4
      			},
      			strokeDashArray: 4,
      		},
      		xaxis: {
      			labels: {
      				padding: 0
      			},
      			tooltip: {
      				enabled: false
      			},
      			axisBorder: {
      				show: false,
      			},
      			categories: [@foreach($operations as $opr) "{{ $opr->type }}", @endforeach],
      		},
      		yaxis: {
      			labels: {
      				padding: 4
      			},
      		},
      		colors: ["#4F81BD"],
      		legend: {
      			show: false,
      		},
      	})).render();
      });
      // @formatter:on
    </script>

</div>
