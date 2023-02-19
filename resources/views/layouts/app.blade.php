<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->


    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet"/>

    @section('links')
    @show

    @livewireStyles
</head>
<body class="antialiased theme-dark">
  <div class="page">
    <header class="navbar navbar-expand-md navbar-dark">
      <div class="container-xl">
        
        <a href="{{ route('home') }}" class="navbar-brand d-none-navbar-horizontal pr-0 pr-md-3">
          <img src="{{ asset('img/imbalance.jpg') }}" alt="Imbalance" class="navbar-brand-image">
        </a>

        <div class="navbar-nav flex-row order-md-last">
          <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown" aria-expanded="false">
              <span class="avatar avatar-md bg-green-lt">{{substr(auth()->user()->name,0,1)?? ''}}</span>
              <div class="d-none d-xl-block pl-2">
                <div>{{ auth()->user()->name }}</div>
                <div class="mt-1 small text-muted">{{ auth()->user()->email }}</div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><polyline points="5 12 3 12 12 3 21 12 19 12"></polyline><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path></svg>
                Home
              </a>
              <a class="dropdown-item" href="{{ route('password.get') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                Change Password
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M7 6a7.75 7.75 0 1 0 10 0"></path><line x1="12" y1="4" x2="12" y2="12"></line></svg>
                Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
            </div>
          </div>
        </div>
        
      </div>
    </header>
    <div class="content">
      <div class="container-xl">
        <div class="row row-deck row-cards">

          @include('layouts.partials.message')
          @section('content')
          @show

        </div>
      </div>
      <footer class="footer footer-transparent">
        <div class="container">
          <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                Copyright © <?= date('Y'); ?>
                <a href="{{ route('home') }}" class="link-secondary">{{ config('app.name') }}</a>.
                 All rights reserved.
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

<!-- Libs JS -->
<script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>

@livewireScripts

@section('scripts')
@show
</body>
</html>