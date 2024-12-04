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
            <h1 class="h3 text-gray-800 mb-0">Voucher Management</h1>
            <p class="text-muted mb-0">Manage and organize platform vouchers</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Create New Voucher
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 rounded-start ps-4">Code</th>
                            <th class="border-0">Points Required</th>
                            <th class="border-0">Description</th>
                            <th class="border-0">Expiration</th>
                            <th class="border-0">User Limit</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Color</th>
                            <th class="border-0 rounded-end text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vouchers as $voucher)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($voucher->image)
                                            <img src="{{ Storage::url($voucher->image) }}" 
                                                 alt="Voucher Image" 
                                                 class="rounded me-2"
                                                 width="40">
                                        @endif
                                        <a href="{{ route('admin.vouchers.show', $voucher->id) }}" 
                                           class="text-decoration-none">
                                            {{ $voucher->code }}
                                        </a>
                                    </div>
                                </td>
                                <td>{{ number_format($voucher->points_required) }}</td>
                                <td>{{ Str::limit($voucher->description, 50) }}</td>
                                <td>
                                    @if($voucher->expiration_date)
                                        {{ \Carbon\Carbon::parse($voucher->expiration_date)->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">No expiration</span>
                                    @endif
                                </td>
                                <td>
                                    @if($voucher->user_limit)
                                        {{ $voucher->userVouchers()->count() }}/{{ $voucher->user_limit }}
                                    @else
                                        <span class="text-muted">Unlimited</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $voucher->status === 'active' ? 'success' : 'danger' }}-subtle 
                                                   text-{{ $voucher->status === 'active' ? 'success' : 'danger' }} rounded-pill">
                                        {{ ucfirst($voucher->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="color-box" style="background-color: {{ $voucher->background_color }}"></div>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.vouchers.show', $voucher->id) }}" 
                                       class="btn btn-sm btn-light me-2" 
                                       data-bs-toggle="tooltip" 
                                       title="View Details">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" 
                                       class="btn btn-sm btn-light me-2" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Voucher">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" 
                                          method="POST" 
                                          class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-light" 
                                                data-bs-toggle="tooltip"
                                                title="Delete Voucher"
                                                onclick="return confirm('Are you sure you want to delete this voucher?')">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">No vouchers found</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $vouchers->links() }}
    </div>
</div>

@push('styles')
<style>
    .color-box {
        width: 30px;
        height: 30px;
        border-radius: 4px;
        display: inline-block;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
@endsection