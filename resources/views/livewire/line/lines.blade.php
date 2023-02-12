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
						<th>Floor</th>
						<th>Line</th>
						<th>Allowance</th>
						<th>Achieved</th>
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
						<td class="text-muted">{{ $line->achieved }}</td>
						<td><a href="{{ route('operations', $line->id) }}" class="btn btn-sm btn-info" tabindex="-1">See Operations</a></td>
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



</div>
