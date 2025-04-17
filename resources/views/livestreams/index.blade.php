@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold text-primary">Livestreams</h5>
                <a href="{{ route('livestreams.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add Livestream
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-nowrap text-secondary small">
                                <th>#</th>
                                <th>Thumbnail</th>
                                <th>Title</th>
                                <th>Stream</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($livestreams as $livestream)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <a href="{{ route('livestreams.show', $livestream->slug) }}">
                                            <img src="{{ asset('storage/' . $livestream->thumbnail) }}"
                                                class="img-fluid rounded border" alt="Thumbnail"
                                                style="height: 50px; width: 75px; object-fit: cover;">
                                        </a>
                                    </td>

                                    <td style="max-width: 220px;">
                                        <a href="{{ route('livestreams.show', $livestream->slug) }}"
                                            class="d-block text-dark fw-medium text-truncate"
                                            title="{{ $livestream->title }}">
                                            {{ $livestream->title }}
                                        </a>
                                    </td>

                                    <td style="max-width: 280px;">
                                        <a href="{{ route('livestreams.show', $livestream->slug) }}"
                                            class="text-muted d-block text-truncate small"
                                            title="{{ $livestream->embed_url }}">
                                            {{ $livestream->embed_url }}
                                        </a>
                                    </td>

                                    <td>
                                        <span
                                            class="badge px-3 py-2 rounded-pill {{ $livestream->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $livestream->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <td class="text-end text-nowrap">
                                        <a href="{{ route('front.livestream.show', $livestream->slug) }}" target="_blank"
                                            class="btn btn-sm btn-info me-1">
                                            <i class="bi bi-eye text-white"></i>
                                        </a>
                                        <a href="{{ route('livestreams.edit', $livestream->slug) }}"
                                            class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('livestreams.destroy', $livestream->slug) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this livestream?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No livestreams available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($livestreams->hasPages())
                <div class="card-footer bg-white border-top d-flex justify-content-center">
                    {{ $livestreams->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
