@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Livestream</h5>
                <a href="{{ route('livestreams.index') }}" class="btn btn-secondary btn-sm">Go Back</a>
            </div>

            <form action="{{ route('livestreams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Admin User Selection -->
                        @if (Auth::user()->role == 'admin')
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">Select User</label>
                                <select name="user_id" id="user_id"
                                    class="form-control select2 @error('user_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select a user</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', Auth::user()->id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        @endif

                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                placeholder="Enter title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" name="thumbnail" id="thumbnail"
                                class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <!-- Preview Thumbnail -->
                            <div id="thumbnail-preview" class="mt-2" style="display: none;">
                                <strong>Preview:</strong><br>
                                <img src="" id="thumbnail-image" class="img-fluid rounded border"
                                    style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="embed_url" class="form-label">Embed URL</label>
                            <input type="url" name="embed_url" id="embed_url"
                                class="form-control @error('embed_url') is-invalid @enderror"
                                value="{{ old('embed_url') }}" placeholder="Paste livestream embed URL" required>
                            @error('embed_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Write a short description...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 d-flex align-items-center mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                    class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Is Active</label>
                            </div>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end gap-1">
                    <a href="{{ route('livestreams.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Livestream</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@include('livestreams.script')
