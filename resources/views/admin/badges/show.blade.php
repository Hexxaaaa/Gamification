@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.badges.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Badges
        </a>
    </div>
    
    <div class="row g-4">
        <!-- Badge Details Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="text-primary mb-4">Badge Details</h5>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Name</small>
                        <strong>{{ $badge->name }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Level</small>
                        <strong>{{ $badge->level }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Points Required</small>
                        <strong>{{ number_format($badge->points_required) }}</strong>
                    </div>


                    <div class="mb-3">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge bg-{{ $badge->status === 'collected' ? 'success' : ($badge->status === 'available' ? 'primary' : 'secondary') }}-subtle text-{{ $badge->status === 'collected' ? 'success' : ($badge->status === 'available' ? 'primary' : 'secondary') }} rounded-pill">
                            {{ ucfirst($badge->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Description</small>
                        <p class="mb-0">{{ $badge->description }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.badges.edit', $badge->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.badges.destroy', $badge->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this badge?')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection