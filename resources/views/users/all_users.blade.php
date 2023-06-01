@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto">
                <h2 class="page-title">All Users</h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('home') }}" class="btn btn-sm btn-secondary" title="See all clients">Clients</a>
            </div>
        </div>
    </div>

    @forelse($users as $key => $roleType)
    <div class="card mb-5">
        <div class="card-header justify-content-between">
            <h4 class="card-title text-capitalize">Role: {{ $key }}</h4>
            {{-- <a href="{{ route('home') }}" class="btn btn-sm btn-secondary" title="See all clients">Clients</a> --}}
        </div>
        <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped text-nowrap">
            <thead>
                <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                @if(in_array($key, ['CiC','user','viewer']))
                    <th>Client</th>
                @endif
                @if($key == 'user')
                    <th>Assigned To</th>
                @endif
                <th class="w-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roleType as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    @if(in_array($key, ['CiC','user','viewer']))
                        <td>{{ $user->client->client_code }}</td>
                    @endif
                    @if($key == 'user')
                        <td title="User ID: {{ $user->assigned_to }}">{{ $user->assignedTo->name }}</td>
                    @endif
                    <td><a href="{{ route('user.get', ['u'=>$user->email]) }}" class="btn btn-sm btn-warning" tabindex="-1" title="Edit this user">Edit</a>
                    <button ondblclick="document.getElementById('delete-user-form{{$user->id}}').submit();" class="btn btn-sm btn-danger" tabindex="-1" title="Double click to delete this user">Delete</button>
                    <form id="delete-user-form{{$user->id}}" action="{{ route('user.delete',$user) }}" method="POST">
                        @csrf
                    </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No data found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
    @empty
    @endforelse
@endsection
