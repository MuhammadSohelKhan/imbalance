<div class="box">
	
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Analysis of Line-1</h4>
		</div>
		<div class="table-responsive">
			<table class="table table-vcenter card-table table-striped table-bordered text-center">
				<thead>
					<tr>
						<th colspan="9" style="font-size: 1.2rem;">Imbalance check <br>{{ $summary->company }}</th>
						<th style="font-size: 1.2rem; vertical-align: middle;"><a href="{{ route('lines', $line->id)}}"><u>Back</u></a></th>
					</tr>
					<tr>
						<th colspan="2">Buyer</th>
						<th>{{ $summary->buyer}}</th>

						<th style="border-bottom-color: #fff;"></th>
						<th>Floor</th>
						<th>{{ $line->floor }}</th>
						<th style="border-bottom-color: #fff;"></th>
						<th colspan="2">Possible Output</th>
						<th>{{ $operations->min('capacity_per_hour') }}</th>
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
						<th id="imbalanceCell">12%</th>
					</tr>
					<tr>
						<th colspan="2"></th>
						<th></th>

						<th></th>
						<th>Allowance</th>
						<th>{{ $line->allowance }}%</th>
						<th></th>
						<th colspan="2">Balance</th>
						<th id="balanceCell">88%</th>
					</tr>
				</thead>
				<thead>
					<tr>
						<th>SL</th>
						<th>Type</th>
						<th>Machine</th>
						<th>Avg Cycle Time</th>
						<th>Cycle Time With Allowance</th>
						<th>Allocated MP</th>
						<th>Dedicated Cycle Time</th>
						<th>Capacity Per Hour</th>
						<th>Possible Output</th>
						<th>Minutes Lost Per Hour</th>

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
						<td>{{ $operation->cycle_time_with_allowance }}</td>
						<td>{{ $operation->allocated_man_power }}</td>
						<td>{{ $operation->dedicated_cycle_time }}</td>
						<td>{{ $operation->capacity_per_hour }}</td>
						<td>{{ $minCapacity ?? '' }}</td>
						@php 
						$capDiff = ($operation->capacity_per_hour - $minCapacity) * $operation->cycle_time_with_allowance;
						$totalLostMin += $capDiff;
						@endphp
						<td>{{ round($capDiff) }}</td>

						<td class="px-4" style="border-top-color: #fff; border-bottom-color: #fff;"></td>

						@forelse($operation->stages as $stage)
						<td class="text-muted">{{ $stage->first }}</td>
						<td class="text-muted">{{ $stage->second }}</td>
						<td class="text-muted">{{ $stage->third }}</td>
						<td class="text-muted">{{ $stage->fourth }}</td>
						<td class="text-muted">{{ $stage->fifth }}</td>
						@empty
						<td colspan="5"></td>
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
						<td>{{ $operations->avg('capacity_per_hour') }}</td>
						<td>{{ $minCapacity }}</td>
						<td>{{ $totalLostMin }}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

	@php
	$imbalance = $totalLostMin / ($totalMP * 60);
	$balance = 1 - $imbalance;
	@endphp

	<script type="text/javascript">
		document.getElementById('imbalanceCell').innerHTML = {{ round($imbalance * 100)}}+'%';
		document.getElementById('balanceCell').innerHTML = {{ round($balance * 100) }}+'%';
	</script>

</div>




{{-- <div class="box">


	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Analysis of Line-{{ (count($operations)) ? $operations[0]->line->line : '' }}</h4>
		</div>
		<div class="table-responsive">
			<table class="table table-vcenter card-table table-striped table-bordered text-center">
				<thead>
					<tr>
						<th>SL</th>
						<th>Type</th>
						<th>Machine</th>
						<th>Avg Cycle Time</th>
						<th>Cycle Time With Allowance</th>
						<th>Allocated MP</th>
						<th>Dedicated Cycle Time</th>
						<th>Capacity Per Hour</th>
						<th>Possible Output</th>
						<th>Minutes Lost Per Hour</th>

						<th class="px-4" style="border-bottom-color: #fff;"></th>

						@for($s=1;$s<=$operations->max('stages_count');$s++)
						<th class="w-1" colspan="5">Operation-{{ $s }}</th>
						@endfor
					</tr>
				</thead>
				<tbody class=" text-nowrap">
					@forelse($operations as $operation)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $operation->type }}</td>
						<td>{{ $operation->machine }}</td>
						<td>{{ $operation->average_cycle_time }}</td>
						<td>{{ $operation->cycle_time_with_allowance }}</td>
						<td>{{ $operation->allocated_man_power }}</td>
						<td>{{ $operation->dedicated_cycle_time }}</td>
						<td>{{ $operation->capacity_per_hour }}</td>
						<td>{{ $minCapacity ?? '' }}</td>
						<td>{{ round(($operation->capacity_per_hour - $minCapacity) * $operation->cycle_time_with_allowance) }}</td>

						<td class="px-4" style="border-top-color: #fff; border-bottom-color: #fff;"></td>

						@forelse($operation->stages as $stage)
						<td class="text-muted">{{ $stage->first }}</td>
						<td class="text-muted">{{ $stage->second }}</td>
						<td class="text-muted">{{ $stage->third }}</td>
						<td class="text-muted">{{ $stage->fourth }}</td>
						<td class="text-muted">{{ $stage->fifth }}</td>
						@empty
						<td colspan="5"></td>
						@endforelse
					</tr>
					@empty
					<tr>
            			<td colspan="10" class="text-center">No data found.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>



</div> --}}
