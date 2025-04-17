<?php

namespace App\Http\Controllers;

use App\Models\Livestream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index()
    {
        $livestreams = Livestream::with('user')
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('front.index', compact('livestreams'));
    }

    public function show($slug)
    {
        $livestream = Livestream::with('user')->where('slug', $slug)->firstOrFail();

        if (!$livestream->is_active) {
            $isOwner = Auth::check() && $livestream->user_id === Auth::id();
            $isAdmin = Auth::check() && Auth::user()->role === 'admin';

            if (!$isOwner && !$isAdmin) {
                return redirect()->route('front.index')->with('error', 'Livestream not found or inactive.');
            }
        }

        return view('front.show', compact('livestream'));
    }
}
