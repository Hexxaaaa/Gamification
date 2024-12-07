@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="h3 text-gray-800 mb-0">Activity Log</h1>
            <p class="text-muted mb-0">Track and monitor system-wide activities</p>
        </div>
    </div>

    <!-- Activity Log Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 rounded-start ps-4">Description</th>
                            <th class="border-0">Performed By</th>
                            <th class="border-0">Subject</th>
                            <th class="border-0 rounded-end">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-history text-primary me-2"></i>
                                        {{ $activity->description }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($activity->causer)
                                            <div class="avatar-circle me-2" 
                                                 style="background-color: #{{ substr(md5($activity->causer->name), 0, 6) }}">
                                                {{ strtoupper(substr($activity->causer->name, 0, 1)) }}
                                            </div>
                                            {{ $activity->causer->name }}
                                        @else
                                            <i class="fas fa-robot me-2"></i> System
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                    </span>
                                </td>
                                <td>
                                    <i class="far fa-clock me-1"></i>
                                    {{ $activity->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="{{ asset('images/no-data.svg') }}" alt="No activities" class="mb-3" width="96">
                                    <p class="text-muted mb-0">No activities recorded yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-center">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    .badge {
        font-weight: 500;
    }

    .table th {
        font-weight: 600;
    }

    .pagination {
        margin-bottom: 0;
    }
</style>
@endpush
@endsection