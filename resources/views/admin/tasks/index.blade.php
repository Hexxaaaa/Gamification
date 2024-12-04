@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="h3 text-gray-800 mb-0">Task Management</h1>
            <p class="text-muted mb-0">Manage and organize platform tasks</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Create New Task
            </a>
        </div>
    </div>


    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 rounded-start ps-4">#</th>
                            <th class="border-0">Description</th>
                            <th class="border-0">Points</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Deadline</th>
                            <th class="border-0">Expiration</th>
                            <th class="border-0">Featured</th>
                            <th class="border-0 rounded-end text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $key => $task)
                        <tr>
                            <td class="ps-4">{{ $tasks->firstItem() + $key }}</td>
                            <td>
                                <a href="{{ route('admin.tasks.show', $task->id) }}" class="text-decoration-none">
                                    {{ Str::limit($task->description, 50) }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-success rounded-pill">{{ number_format($task->points) }}</span>
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'pending' => 'warning',
                                        'active' => 'primary', 
                                        'completed' => 'success',
                                        'expired' => 'danger'
                                    ][$task->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} rounded-pill">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>
                                <i class="far fa-calendar-alt text-muted me-1"></i>
                                {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y H:i') }}
                            </td>
                            <td>
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $deadline = \Carbon\Carbon::parse($task->deadline);
                                    $isExpired = $now->gt($deadline);
                                @endphp
                                
                                @if($isExpired)
                                    <span class="badge bg-danger-subtle text-danger">
                                        <i class="fas fa-clock me-1"></i>Expired
                                    </span>
                                @else
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($task->featured)
                                    <span class="badge bg-info-subtle text-info">
                                        <i class="fas fa-star me-1"></i>Featured
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.tasks.edit', $task->id) }}" 
                                   class="btn btn-sm btn-light me-2" 
                                   data-bs-toggle="tooltip" 
                                   title="Edit Task">
                                    <i class="fas fa-edit text-primary"></i>
                                </a>
                                <form action="{{ route('admin.tasks.destroy', $task->id) }}" 
                                      method="POST" 
                                      class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-light" 
                                            data-bs-toggle="tooltip" 
                                            title="Delete Task"
                                            onclick="return confirm('Are you sure you want to delete this task?')">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection