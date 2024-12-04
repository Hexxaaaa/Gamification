@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Vouchers
        </a>
    </div>
    
    <div class="row g-4">
        <!-- Voucher Details Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="text-primary mb-4">Voucher Details</h5>
                    
                    @if($voucher->image)
                    <div class="mb-4">
                        <img src="{{ Storage::url($voucher->image) }}" 
                             alt="Voucher Image" 
                             class="img-fluid rounded">
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Code</small>
                        <strong>{{ $voucher->code }}</strong>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Points Required</small>
                        <strong>{{ number_format($voucher->points_required) }}</strong>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge bg-{{ $voucher->status === 'active' ? 'success' : 'danger' }}-subtle 
                                     text-{{ $voucher->status === 'active' ? 'success' : 'danger' }} rounded-pill">
                            {{ ucfirst($voucher->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">User Limit</small>
                        @if($voucher->user_limit)
                            <strong>{{ $voucher->userVouchers()->count() }}/{{ $voucher->user_limit }}</strong>
                        @else
                            <span class="text-muted">Unlimited</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Expiration Date</small>
                        @if($voucher->expiration_date)
                            <strong>{{ \Carbon\Carbon::parse($voucher->expiration_date)->format('M d, Y') }}</strong>
                        @else
                            <span class="text-muted">No expiration</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Description</small>
                        <p class="mb-0">{{ $voucher->description }}</p>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted d-block">Background Color</small>
                        <div class="d-flex align-items-center">
                            <div class="color-preview me-2" style="background-color: {{ $voucher->background_color }}"></div>
                            <code>{{ $voucher->background_color }}</code>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this voucher?')">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Redemption History Card -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="text-primary mb-4">Redemption History</h5>
                    
                    @if($redemptions->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>User</th>
                                        <th>Redeemed At</th>
                                        <th>Points Used</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($redemptions as $redemption)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $redemption->user->avatar ?? asset('images/default-avatar.png') }}" 
                                                         class="rounded-circle me-2" 
                                                         width="32" height="32" 
                                                         alt="User avatar">
                                                    {{ $redemption->user->name }}
                                                </div>
                                            </td>
                                            <td>{{ $redemption->created_at->format('M d, Y H:i') }}</td>
                                            <td>{{ number_format($voucher->points_required) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $redemptions->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <img src="{{ asset('images/no-data.svg') }}" 
                                 alt="No redemptions" 
                                 class="mb-3" 
                                 width="150">
                            <h6 class="text-muted">No redemptions yet</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .color-preview {
        width: 30px;
        height: 30px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
</style>
@endpush