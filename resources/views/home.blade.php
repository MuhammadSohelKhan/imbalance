@extends('layouts.app')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-auto">
				<h2 class="page-title">
					Dashboard
				</h2>
			</div>
		</div>
	</div>

	<div class="row row-deck row-cards">
		<div class="col-sm-6 col-xl-4">
			<div class="card card-sm">
				<a href="#" data-toggle="modal" data-target="#modal-report">
					<div class="card-body d-flex align-items-center">
					<span class="bg-green text-white stamp mr-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="9" cy="19" r="2"></circle><circle cx="17" cy="19" r="2"></circle><path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2"></path></svg>
					</span>
						<div class="mr-3 lh-sm">
							<div class="strong">
								Start New Operation
							</div>
							<div class="text-muted">Summary</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>

	<livewire:summary.summaries />

@endsection


@section('scripts')
	

    {{-- <script type="text/javascript">
    	window.addEventListener('resetModalForm', function () {
    		document.getElementById('summary-form').reset();
    		const formSpans = document.querySelectorAll("#summary-form div.mb-3 span.text-danger");
    		for (var i = 0; i < formSpans.length; i++) {
    			formSpans[i].innerHTML = '';
    		}
    	})
    </script> --}}
@endsection

