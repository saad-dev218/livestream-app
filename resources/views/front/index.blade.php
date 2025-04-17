@extends('layouts.app')
@section('title', 'Home - ' . config('app.name'))
@section('content')
    <!-- Main Content -->
    <div class="container my-3">
        <h2 class="mb-3 text-center fw-bold">🔥 Trending Live Streams</h2>
        <div class="row g-4 pt-4">

            @if (count($livestreams) > 0)
                @foreach ($livestreams as $stream)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <a href="{{ route('front.livestream.show', $stream['slug']) }}" class="text-decoration-none">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $stream['thumbnail']) }}" class="card-img-top"
                                    alt="Stream Thumbnail">
                                <div class="card-body d-flex flex-column">
                                    <div class="streamer-name">by <strong>{{ $stream['user']['name'] }}</strong></div>
                                    <h5 class="card-title">{{ $stream['title'] }}</h5>
                                    <a href="{{ route('front.livestream.show', $stream['slug']) }}"
                                        class="btn btn-primary mt-auto">Watch Now</a>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
