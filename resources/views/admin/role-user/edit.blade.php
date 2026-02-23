@extends('admin.layouts.app')

@push('title', 'Edit Admin User')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Edit Admin User
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('admin.role-user.index') }}" class="btn btn-secondary">
                    Back to Admins
                </a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form action="{{ route('admin.role-user.update', $user->id) }}" method="POST" class="card">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4 class="card-title">User Account Details</h4>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Full Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="{{ old('username', $user->username) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Assign Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="" disabled>Select a role...</option>
                                    @php
                                    // Find user's current role if they have one assigned via Spatie
                                    $currentUserRole = $user->roles->first()?->name;
                                    @endphp
                                    @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ (old('role', $currentUserRole) == $role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr class="my-4">

                            <div class="col-12 mb-3">
                                <h4 class="mb-0">Update Password</h4>
                                <small class="text-secondary">Leave password fields blank if you do not want to alter this user's password.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Update Admin User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection