@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6 mb-0 text-primary">User Details</h1>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Users
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-4">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}"
                                 class="avatar-circle me-3"
                                 alt="{{ $user->name }}'s profile photo">
                        @else 
                            <div class="avatar-circle me-3" 
                                 style="background-color: #{{ substr(md5($user->name), 0, 6) }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h2 class="h4 mb-1">{{ $user->name }}</h2>
                            <div>
                                @if($user->is_admin)
                                    <span class="badge bg-primary-subtle text-primary rounded-pill">Admin</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill">User</span>
                                @endif
                                <span class="badge bg-{{ $user->active ? 'success' : 'danger' }}-subtle 
                                             text-{{ $user->active ? 'success' : 'danger' }} rounded-pill ms-2">
                                    {{ $user->active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 bg-light">
                                <h6 class="text-muted mb-2">Email Address</h6>
                                <p class="mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 bg-light">
                                <h6 class="text-muted mb-2">Phone Number</h6>
                                <p class="mb-0">{{ $user->phone_number ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 bg-light">
                                <h6 class="text-muted mb-2">Age</h6>
                                <p class="mb-0">{{ $user->age ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 bg-light">
                                <h6 class="text-muted mb-2">Location</h6>
                                <p class="mb-0">{{ $user->location ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 bg-light">
                                <h6 class="text-muted mb-2">Created At</h6>
                                <p class="mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-lg me-2">
                            <i class="fas fa-edit me-2"></i>Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-list me-2"></i>View All Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avatar-circle {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    font-size: 1.5rem;
}
</style>
@endpush
@endsection