@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-6 mb-0 text-primary">Edit Task</h1>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea name="description" id="description" class="form-control" style="height: 100px" required>{{ old('description', $task->description) }}</textarea>
                                <label for="description">Task Description</label>
                            </div>
                        </div>

                        <!-- Points and Status -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="points" id="points" class="form-control"
                                    value="{{ old('points', $task->points) }}" required>
                                <label for="points">Points</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="status" id="status" class="form-select" required>
                                    <option value="pending"
                                        {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="active" {{ old('status', $task->status) == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="completed"
                                        {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed
                                    </option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input type="datetime-local" 
                                       name="deadline" 
                                       id="deadline" 
                                       class="form-control"
                                       value="{{ old('deadline', $task->deadline ? date('Y-m-d\TH:i', strtotime($task->deadline)) : '') }}"
                                       min="{{ now()->format('Y-m-d\TH:i') }}" 
                                       required>
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
                                            id="video_type_youtube"
                                            {{ old('video_type', $task->video_type) != 'file' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="video_type_youtube">
                                            <i class="fab fa-youtube me-2"></i>YouTube URL
                                        </label>

                                        <input type="radio" class="btn-check" name="video_type" value="file"
                                            id="video_type_file"
                                            {{ old('video_type', $task->video_type) == 'file' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="video_type_file">
                                            <i class="fas fa-file-video me-2"></i>Video File
                                        </label>
                                    </div>

                                    <div id="video_url_group">
                                        <div class="form-floating">
                                            <input type="url" name="video_url" id="video_url" class="form-control"
                                                value="{{ old('video_url', $task->video_url) }}">
                                            <label for="video_url">YouTube Video URL</label>
                                        </div>
                                    </div>

                                    <div id="video_file_group" class="d-none">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-video"></i></span>
                                            <input type="file" name="video_file" id="video_file" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <div class="col-12">
                            <label class="form-label">Thumbnail Image</label>
                            @if ($task->thumbnail_url)
                                <div class="card bg-light border-0 rounded-3 mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $task->thumbnail_url }}" alt="Current Thumbnail" class="rounded-3"
                                                style="max-width: 200px;">
                                            <div class="ms-3">
                                                <p class="text-muted mb-0">Current thumbnail</p>
                                                <small class="text-muted">Upload a new image to replace it</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-image"></i></span>
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                            </div>
                        </div>

                        <!-- Featured -->
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="featured" id="featured" value="1"
                                    class="form-check-input" {{ old('featured', $task->featured) ? 'checked' : '' }}>
                                <label for="featured" class="form-check-label">
                                    Set as Featured Task
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i>Update Task
                            </button>
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
