@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <h1 class="display-6 mb-4 text-primary">Create New Task</h1>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 shadow-sm">
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea name="description" id="description" class="form-control" style="height: 100px" required>{{ old('description') }}</textarea>
                                <label for="description">Task Description</label>
                            </div>
                        </div>

                        <!-- Points and Status -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="points" id="points" class="form-control"
                                    value="{{ old('points') }}" required>
                                <label for="points">Points</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="status" id="status" class="form-select" required>
                                    <option value="active" selected>Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                        </div>

                        <!-- Deadline -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="datetime-local" name="deadline" id="deadline" class="form-control"
                                    value="{{ old('deadline') }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                                <label for="deadline">Deadline</label>
                                <small class="text-muted">Deadline must be a future date and time</small>
                            </div>
                        </div>

                        <!-- Video Section -->
                        <div class="col-12">
                            <div class="card bg-light border-0 rounded-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Video Content</h5>

                                    <div class="btn-group mb-3" role="group">
                                        <input type="radio" class="btn-check" name="video_type" value="youtube"
                                            id="video_type_youtube" {{ old('video_type') != 'file' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="video_type_youtube">
                                            <i class="bi bi-youtube me-2"></i>YouTube URL
                                        </label>

                                        <input type="radio" class="btn-check" name="video_type" value="file"
                                            id="video_type_file" {{ old('video_type') == 'file' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="video_type_file">
                                            <i class="bi bi-file-earmark-play me-2"></i>Video File
                                        </label>
                                    </div>

                                    <div id="video_url_group">
                                        <div class="form-floating">
                                            <input type="url" name="video_url" id="video_url" class="form-control"
                                                value="{{ old('video_url') }}">
                                            <label for="video_url">YouTube Video URL</label>
                                        </div>
                                    </div>

                                    <div id="video_file_group" class="d-none">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-camera-video"></i></span>
                                            <input type="file" name="video_file" id="video_file" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <div class="col-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-image"></i></span>
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control" required>
                            </div>
                        </div>

                        <!-- Featured -->
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="featured" id="featured" value="1"
                                    class="form-check-input" {{ old('featured') ? 'checked' : '' }}>
                                <label for="featured" class="form-check-label">Set as Featured Task</label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-plus-circle me-2"></i>Create Task
                            </button>
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Tasks
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const videoTypeRadios = document.querySelectorAll('input[name="video_type"]');
                const videoUrlGroup = document.getElementById('video_url_group');
                const videoFileGroup = document.getElementById('video_file_group');

                function toggleVideoFields() {
                    if (document.getElementById('video_type_file').checked) {
                        videoUrlGroup.classList.add('d-none');
                        videoFileGroup.classList.remove('d-none');
                    } else {
                        videoUrlGroup.classList.remove('d-none');
                        videoFileGroup.classList.add('d-none');
                    }
                }

                videoTypeRadios.forEach(radio => {
                    radio.addEventListener('change', toggleVideoFields);
                });

                toggleVideoFields();
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .form-floating>.form-control:focus,
            .form-floating>.form-control:not(:placeholder-shown) {
                padding-top: 1.625rem;
                padding-bottom: .625rem;
            }

            .card {
                transition: all 0.3s ease;
            }

            .btn {
                transition: all 0.3s ease;
            }
        </style>
    @endpush
@endsection
