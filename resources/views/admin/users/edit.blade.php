@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-6 mb-0 text-primary">Edit User</h1>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Users
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required>
                                <label for="name">Full Name</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                                <label for="email">Email Address</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="phone_number" id="phone_number" class="form-control"
                                    value="{{ old('phone_number', $user->phone_number) }}">
                                <label for="phone_number">Phone Number</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="age" id="age" class="form-control"
                                    value="{{ old('age', $user->age) }}" min="0">
                                <label for="age">Age</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" name="location" id="location" class="form-control"
                                    value="{{ old('location', $user->location) }}">
                                <label for="location">Location</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" name="password" id="password" class="form-control">
                                <label for="password">Password</label>
                                <small class="text-muted">Leave empty if you don't want to change the password.</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="is_admin" id="is_admin" class="form-select" required>
                                    <option value="0" {{ old('is_admin', $user->is_admin) == '0' ? 'selected' : '' }}>
                                        No</option>
                                    <option value="1" {{ old('is_admin', $user->is_admin) == '1' ? 'selected' : '' }}>
                                        Yes</option>
                                </select>
                                <label for="is_admin">Admin Role</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="active" id="active" class="form-select" required>
                                    <option value="1" {{ old('active', $user->active) == '1' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0" {{ old('active', $user->active) == '0' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                <label for="active">Status</label>
                            </div>
                        </div>

                        {{-- Gambar Profil --}}
                        <div class="form-group mb-3">
                            <label for="profile_image">Profile Image</label>
                            <input type="file" id="profile_image" name="profile_image"
                                   class="form-control-file @error('profile_image') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('profile_image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        
                            @if($user->profile_image)
                                <div class="mt-3">
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                         alt="Profile Image"
                                         class="img-thumbnail" width="150">
                                </div>
                            @else
                                <div class="mt-3">
                                    <img src="{{ url('gallery/userfoto.png') }}" 
                                         alt="Default Profile Image"
                                         class="img-thumbnail" width="150">
                                </div>
                            @endif
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i>Update User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
