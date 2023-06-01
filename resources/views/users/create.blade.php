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
                        <form id="registration-form" method="post" action="{{ route('user.post') }}" onsubmit="validateForm(event)">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $user->name ?? "" }}" autocomplete="name" autofocus required>

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
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') ?? $user->email ?? "" }}" autocomplete="email" required>

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
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" maxlength="30" pattern="^[a-zA-Z0-9!@#$%^&*]+$" autocomplete="new-password" onblur="validatePassword()" required>

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
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" autocomplete="new-password" onblur="validatePassword()" required>
                                </div>
                            </div>
                            @endif

                            <div class="row mb-3">
                                <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Select Role') }}</label>

                                <div class="col-md-6">
                                    @foreach($permRoles as $role)
                                    <input type="radio" id="{{$role}}" name="role" value="{{$role}}" style="margin: 0.6rem 0;" @if(old('role')==$role || $user && $user->role==$role) checked="" @endif onclick="handleRoleSelection()" required>
                                    <label for="{{$role}}">{{$role}}</label><br>
                                    @endforeach

                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="client-id-div" class="row mb-3" style="display: none;">
                                <label for="client_code" class="col-md-4 col-form-label text-md-end">{{ __('Client Code') }}</label>

                                <div class="col-md-6">
                                    <input type="text" id="client_code" name="client_code" value="{{ old('user_id') ?? $user->client->client_code ?? '' }}" class="form-control" pattern="CL-[A-Z]{2}-(?!000)\d{3}" title="Please enter a valid client code in the format CL-XX-XXX" autocomplete="client_code" onblur="validateClientCode(this)">

                                    @error('client_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="user-id-div" class="row mb-3" style="display: none;">
                                <label for="user_id" class="col-md-4 col-form-label text-md-end">{{ __('User ID') }}</label>

                                <div class="col-md-6">
                                    <input type="number" id="user_id" name="user_id" value="{{ old('user_id') ?? $user->assigned_to ?? '' }}" class="form-control" autocomplete="user_id">

                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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


<script>
    let passwordWarning = false; // For showing warning messages
    let confirmPasswordWarning = false; // For showing warning messages
    let clientCodeWarning = false; // For showing warning messages

    var cicRadio = document.getElementById("CiC");
    var userRadio = document.getElementById("user");
    var viewerRadio = document.getElementById("viewer");
    var clientIdDiv = document.getElementById("client-id-div");
    var userIdDiv = document.getElementById("user-id-div");
    var clientCodeInput = document.getElementById("client_code");
    var userIdInput = document.getElementById("user_id");


    handleRoleSelection();

    function handleRoleSelection() {
        if (cicRadio.checked || viewerRadio.checked) {
            clientIdDiv.style.display = "flex";
            userIdDiv.style.display = "none";
            clientCodeInput.required = true;
            userIdInput.required = false;
        } else if (userRadio.checked) {
            clientIdDiv.style.display = "flex";
            userIdDiv.style.display = "flex";
            clientCodeInput.required = true;
            userIdInput.required = true;
        } else {
            clientCodeInput.style.borderColor = "";
            clientIdDiv.style.display = "none";
            userIdDiv.style.display = "none";
            clientCodeInput.required = false;
            userIdInput.required = false;
            clientCodeInput.value = ""; // Clear the value
            userIdInput.value = ""; // Clear the value
        }
    }


    function validateForm(event) {
        event.preventDefault();

        @if(! $user)
            if (! validatePassword()) return;
        @endif

        if (cicRadio.checked || viewerRadio.checked) {
            if (! validateClientCode(clientCodeInput)) return;
        }

        // If all validation passes, submit the form
        document.getElementById("registration-form").submit();
    }



    function validatePassword() {
        var warningText = "Password is required";
        var password = document.getElementById("password");
        var confirmPassword = document.getElementById("password-confirm");

        if (!password.value || password.value.length<8 || password.value.length>30) {
            if (password.value && password.value.length < 8) {
                warningText = "Password should be minimum 8";
            } else if (password.value.length > 30) {
                warningText = "Password should be less than 30"
            }
            handleWarning(passwordWarning, "pass-err", password, warningText, "show");
            passwordWarning = true;
            return false;
        }
        if (passwordWarning) {
            handleWarning(passwordWarning, "pass-err", password, warningText, "hide");
            passwordWarning = false;
        }

        if (password.value !== confirmPassword.value) {
            warningText = "Passwords do not match.";
            handleWarning(confirmPasswordWarning, "confirm-pass-err", confirmPassword, warningText, "show");
            confirmPasswordWarning = true;
            return false;
        } else {
            if (confirmPasswordWarning) {
                handleWarning(confirmPasswordWarning, "confirm-pass-err", confirmPassword, warningText, "hide");
                confirmPasswordWarning = false;
            }
            return true;
        }
    }



    function validateClientCode(clientCodeField) {
        const clientCodePattern = /^CL-[A-Z]{2}-(?!000)\d{3}$/;

        if (clientCodePattern.test(clientCodeField.value)) {
            if (clientCodeWarning) {
                handleWarning(clientCodeWarning, "client-err", clientCodeField, "", "hide");
                clientCodeWarning = false;
            }
            return true;
        } else {
            handleWarning(clientCodeWarning, "client-err", clientCodeField, "Please match the pattern: CL-XX-XXX", "show");
            clientCodeWarning = true;
            return false;
        }
    }



    function handleWarning(elem, elemId, position, message, status) {
        if (status == "hide") {
            elem = document.getElementById(elemId);
            elem.parentNode.removeChild(elem);
            position.style.borderColor = "";
            return;
        }

        if (! elem) {
            elem = document.createElement('span');
            elem.id = elemId;
            elem.style.color = "red";
            position.parentNode.insertBefore(elem, position.nextSibling);
        } else {
            elem = document.getElementById(elemId);
        }
        position.focus();
        elem.textContent = message;
        position.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Scroll to desired field
    }
</script>



@endsection
