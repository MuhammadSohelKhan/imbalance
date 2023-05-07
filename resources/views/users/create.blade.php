@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="page-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h2 class="page-title">
                        Add New User
                    </h2>
                </div>
                <div class="col-auto">
                    <a href="{{ route('users.all') }}" class="btn btn-sm btn-info" title="See all users">
                        All User
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('user.post') }}" method="post">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name ?? "" }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email ?? "" }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @if(! $user)
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            @endif

                            <div class="row mb-3">
                                <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Select Role') }}</label>

                                <div class="col-md-6">
                                    @if($aUser->role=="Master")
                                    <input type="radio" id="Master" name="role" value="Master" @if(old('role')=='Master' || $user && $user->role=='Master') checked="" @endif>
                                    <label for="Master">Master</label><br>
                                    @endif

                                    @if(in_array($aUser->role,['Master','superadmin']))
                                    <input type="radio" id="superadmin" name="role" value="superadmin" @if(old('role')=='superadmin' || $user && $user->role=='superadmin') checked="" @endif>
                                    <label for="superadmin">Super Admin</label><br>
                                    @endif

                                    <input type="radio" id="admin" name="role" value="admin" style="margin: 1.2rem 0;" @if(old('role')=='admin' || $user && $user->role=='admin') checked="" @endif>
                                    <label for="admin">Admin</label><br>

                                    <input type="radio" id="user" name="role" value="user" @if(! old('role') && !$user || old('role')=='user' || $user && $user->role=='user') checked="" @endif>
                                    <label for="user">User</label>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
