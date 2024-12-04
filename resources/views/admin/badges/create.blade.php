@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6 mb-0 text-primary">Create New Badge</h1>
                <a href="{{ route('admin.badges.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Badges
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

            <form action="{{ route('admin.badges.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            <label for="name">Badge Name</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" name="points_required" id="points_required" class="form-control" value="{{ old('points_required') }}" required>
                            <label for="points_required">Points Required</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" name="level" id="level" class="form-control" value="{{ old('level') }}" required>
                            <label for="level">Level</label>
                        </div>
                    </div>

    

                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="description" id="description" class="form-control" style="height: 100px" required>{{ old('description') }}</textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <select name="status" id="status" class="form-select" required>
                                <option value="collected" {{ old('status') == 'collected' ? 'selected' : '' }}>Collected</option>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="locked" {{ old('status') == 'locked' ? 'selected' : '' }}>Locked</option>
                            </select>
                            <label for="status">Status</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save me-2"></i>Create Badge
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection