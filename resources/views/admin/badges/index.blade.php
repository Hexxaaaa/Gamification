@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="h3 text-gray-800 mb-0">Badge Management</h1>
            <p class="text-muted mb-0">Manage and organize platform badges</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.badges.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Create New Badge
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 rounded-start ps-4">Name</th>
                            <th class="border-0">Level</th>
                            <th class="border-0">Points Required</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 rounded-end text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($badges as $badge)
                            <tr>
                                <td class="ps-4">{{ $badge->name }}</td>
                                <td>{{ $badge->level }}</td>
                                <td>{{ number_format($badge->points_required) }}</td>
                                <td>
                                    <span class="badge bg-{{ $badge->status === 'collected' ? 'success' : ($badge->status === 'available' ? 'primary' : 'secondary') }}-subtle text-{{ $badge->status === 'collected' ? 'success' : ($badge->status === 'available' ? 'primary' : 'secondary') }} rounded-pill">
                                        {{ ucfirst($badge->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.badges.show', $badge->id) }}" class="btn btn-sm btn-light me-2" data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    <a href="{{ route('admin.badges.edit', $badge->id) }}" class="btn btn-sm btn-light me-2" data-bs-toggle="tooltip" title="Edit Badge">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.badges.destroy', $badge->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Delete Badge" onclick="return confirm('Are you sure you want to delete this badge?')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No badges found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection