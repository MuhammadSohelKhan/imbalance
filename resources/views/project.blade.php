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

	@if($ctrlClient->is_active && in_array($aUser->role, ['Master','superadmin','admin']))
	<div class="row row-deck row-cards">
		<div class="col-sm-6 col-xl-4">
			<div class="card card-sm">
				<a href="#" data-toggle="modal" data-target="#modal-project-operation">
					<div class="card-body d-flex align-items-center">
					<span class="bg-green text-white stamp mr-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
					</span>
						<div class="mr-3 lh-sm">
							<div class="strong text-white">
								Add New Project
							</div>
							<div class="text-muted">Project</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
	@endif

	<livewire:project.projects :aUser="$aUser" :client_id="$ctrlClient->id" :client="$ctrlClient"/>

@endsection
