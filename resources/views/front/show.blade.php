@extends('layouts.app')
@section('title', 'Live Stream - ' . config('app.name'))
@push('styles')
    <style>
        .live-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 25px;
            animation: fadeInUp 0.8s ease forwards;
            margin-bottom: 20px;
        }

        .back-btn {
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .back-btn:hover {

            text-decoration: none;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.25);
        }

        .live-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 6px;
        }

        .live-added-by {
            font-size: 0.95rem;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .live-description {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush
@section('content')
    <div class="container">

        <div class="live-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="live-title">🎥 {{ $livestream->title }}</div>
                <a href="{{ url('/') }}"
                    class="btn  btn-warning shadow-sm rounded-pill px-4 py-2 d-inline-flex align-items-center back-btn">
                    <span class="me-2">←</span> Back
                </a>
            </div>
            <div class="live-added-by">Added by: <strong>{{ $livestream->user->name }}</strong></div>

            <div class="video-wrapper">
                <iframe src="{{ $livestream->embed_url }}" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="live-description">
                <h5 class="fw-bold">Description</h5>
                <p>{{ $livestream->description }}</p>
            </div>
        </div>
    </div>
@endsection
