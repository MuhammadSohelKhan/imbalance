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

    <div class="card">
        <div class="card-header justify-content-between">
            <h4 class="card-title">All Users</h4>
            <a href="{{ route('home') }}" class="btn btn-sm btn-secondary" title="See all clients">Clients</a>
        </div>
        <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped text-nowrap">
            <thead>
                <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th class="w-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
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
    {{-- <div class="card-footer d-flex align-items-center">
        <ul class="pagination m-0 ml-auto">
            {{$users->links()}}
        </ul>
    </div> --}}
</div>
@endsection
