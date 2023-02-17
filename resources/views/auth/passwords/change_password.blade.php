@extends('layouts.app')
@section('content')
    <div class="box">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h2 class="page-title">
                        Change Password
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('password.post') }}" method="post">
                            @method('PATCH')
                            @csrf

                            <div class="form-group mb-3">
                                <label class="form-label required">Current Password</label>
                                <input type="password" class="form-control" name="current_password" @error('current_password') is-invalid @enderror placeholder="Current Password" required>

                                @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label required">New Password</label>
                                <input type="password" class="form-control" name="password" @error('password') is-invalid @enderror placeholder="New Password" required>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label required">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" @error('password_confirmation') is-invalid @enderror placeholder="Confirm Password" required>

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
