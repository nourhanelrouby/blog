@extends('dashboard.layouts.main')
@section('title',$title)

@section('content')

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5>{{$title}}</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('dashboard.users.update',$user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="User Name" value="{{ $user->name }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" placeholder="User Email" value="{{ $user->email }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">Select Role</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="writer" {{ $user->role == 'writer' ? 'selected' : '' }}>Writer</option>
                    </select>
                    @error('role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Update User</button>

            </form>

        </div>
    </div>
</div>

@endsection
