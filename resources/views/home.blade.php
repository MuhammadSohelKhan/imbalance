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
				<div class="card-body d-flex align-items-center">
				<span class="bg-blue text-white stamp mr-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="9" cy="19" r="2"></circle><circle cx="17" cy="19" r="2"></circle><path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2"></path></svg>
				</span>
					<div class="mr-3 lh-sm">
						<div class="strong">
							{{-- $usersCount --}} users
						</div>
						<div class="text-muted ">{{ auth()->user()->name }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-xl-4">
			<div class="card card-sm">
				<a href="{{-- {{ route('menus.index')  --}}}}" title="">
					<div class="card-body d-flex align-items-center">
					<span class="bg-green text-white stamp mr-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="9" cy="19" r="2"></circle><circle cx="17" cy="19" r="2"></circle><path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2"></path></svg>
					</span>
						<div class="mr-3 lh-sm">
							<div class="strong">
								{{-- $menusCount --}} Menus
							</div>
							<div class="text-muted">{{-- $subMenusCount --}} submenus</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-sm-6 col-xl-4">
			<div class="card card-sm">
				<a href="{{-- {{ route('pages.index')  --}}}}" class="p-0 m-0" title="">
					<div class="card-body d-flex align-items-center">
					<span class="bg-red text-white stamp mr-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="9" cy="19" r="2"></circle><circle cx="17" cy="19" r="2"></circle><path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2"></path></svg>
					</span>
						<div class="mr-3 lh-sm">
							<div class="strong">
								{{-- $pagesCount --}} Pages
							</div>
							<div class="text-muted">{{-- $publishedPagesCount --}} published</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Google Analytics will be added here</h4>
			</div>
			<div class="table-responsive">
				<table class="table card-table table-vcenter">
					<thead>
					<tr>
						<th>Page title</th>
						<th>Visitors</th>
						<th>Unique</th>
						<th colspan="2">Bounce rate</th>
					</tr>
					</thead>
					<tbody>


					</tbody>
				</table>
			</div>
		</div>
	</div>



@endsection

