@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6 mb-0 text-primary">Create New Voucher</h1>
                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Vouchers
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.vouchers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   name="code" 
                                   id="code" 
                                   class="form-control" 
                                   value="{{ old('code') }}" 
                                   required>
                            <label for="code">Voucher Code</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" 
                                   name="points_required" 
                                   id="points_required" 
                                   class="form-control" 
                                   value="{{ old('points_required') }}" 
                                   min="0"
                                   required>
                            <label for="points_required">Points Required</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="description" 
                                    id="description" 
                                    class="form-control" 
                                    style="height: 100px" 
                                    required>{{ old('description') }}</textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="status" id="status" class="form-select" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <label for="status">Status</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="color" 
                                   name="background_color" 
                                   id="background_color" 
                                   class="form-control" 
                                   value="{{ old('background_color', '#FFFFFF') }}" 
                                   required>
                            <label for="background_color">Background Color</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" 
                                   name="user_limit" 
                                   id="user_limit" 
                                   class="form-control" 
                                   value="{{ old('user_limit') }}" 
                                   min="1">
                            <label for="user_limit">User Limit (Optional)</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" 
                                   name="expiration_date" 
                                   id="expiration_date" 
                                   class="form-control" 
                                   value="{{ old('expiration_date') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            <label for="expiration_date">Expiration Date (Optional)</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="image" class="form-label">Voucher Image (Optional)</label>
                            <input type="file" 
                                   class="form-control" 
                                   id="image" 
                                   name="image" 
                                   accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text">Maximum file size: 2MB. Accepted formats: JPG, JPEG, PNG</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save me-2"></i>Create Voucher
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-floating > input[type="color"] {
        padding-top: 1rem;
        padding-bottom: 1rem;
        height: calc(3.5rem + 2px);
    }
</style>
@endpush