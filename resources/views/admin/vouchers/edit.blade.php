@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6 mb-0 text-primary">Edit Voucher</h1>
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

            <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   name="code" 
                                   id="code" 
                                   class="form-control" 
                                   value="{{ old('code', $voucher->code) }}" 
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
                                   value="{{ old('points_required', $voucher->points_required) }}" 
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
                                     required>{{ old('description', $voucher->description) }}</textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="status" id="status" class="form-select" required>
                                <option value="active" {{ old('status', $voucher->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $voucher->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                   value="{{ old('background_color', $voucher->background_color) }}" 
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
                                   value="{{ old('user_limit', $voucher->user_limit) }}">
                            <label for="user_limit">User Limit</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" 
                                   name="expiration_date" 
                                   id="expiration_date" 
                                   class="form-control" 
                                   value="{{ old('expiration_date', $voucher->expiration_date) }}">
                            <label for="expiration_date">Expiration Date</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="image" class="form-label">Voucher Image</label>
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   class="form-control"
                                   accept="image/jpeg,image/png">
                            @if($voucher->image)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($voucher->image) }}" 
                                         alt="Current Voucher Image" 
                                         class="img-thumbnail" 
                                         style="max-height: 200px">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save me-2"></i>Update Voucher
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection