@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="h3 text-gray-800 mb-0">User Management</h1>
            <p class="text-muted mb-0">Manage and organize platform users</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Create New User
            </a>
        </div>
    </div>


    <!-- Users Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 rounded-start ps-4">Name</th>
                            <th class="border-0">Email</th>
                            <th class="border-0">Phone</th>
                            <th class="border-0">Location</th>
                            <th class="border-0">Role</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Created</th>
                            <th class="border-0 rounded-end text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                                 alt="{{ $user->name }}"
                                                 class="avatar-circle me-2">
                                        @else
                                            <div class="avatar-circle me-2" 
                                                 style="background-color: #{{ substr(md5($user->name), 0, 6) }}">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number ?? '-' }}</td>
                                <td>{{ $user->location ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->is_admin ? 'primary' : 'secondary' }}-subtle 
                                                 text-{{ $user->is_admin ? 'primary' : 'secondary' }} rounded-pill">
                                        {{ $user->is_admin ? 'Admin' : 'User' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->active ? 'success' : 'danger' }}-subtle 
                                                 text-{{ $user->active ? 'success' : 'danger' }} rounded-pill">
                                        {{ $user->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="btn btn-sm btn-light me-2" 
                                       data-bs-toggle="tooltip" 
                                       title="View Details">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="btn btn-sm btn-light me-2" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit User">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.users.delete', $user->id) }}" 
                                          method="POST" 
                                          class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-light" 
                                                data-bs-toggle="tooltip" 
                                                title="Delete User"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <img src="{{ asset('images/no-data.svg') }}" alt="No users" class="mb-3" width="96">
                                    <p class="mb-0">No users found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
</div>

@push('styles')
<style>
   .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        font-size: 1.2rem;
    }
</style>
@endpush
@endsection