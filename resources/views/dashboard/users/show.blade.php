@extends('dashboard.layouts.main')
@section('title',$title)

@section('content')

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5>{{$title}}</h5>
        </div>

        <div class="card-body">

            <form action="#" method="GET">
                @csrf


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

            </form>

        </div>
    </div>
</div>

@endsection
