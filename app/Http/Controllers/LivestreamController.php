<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLivestreamRequest;
use App\Http\Requests\UpdateLivestreamRequest;
use App\Models\Livestream;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivestreamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livestreams = Livestream::query();

        if (Auth::user()->role !== 'admin') {
            $livestreams->where('user_id', Auth::id());
        }

        $livestreams = $livestreams->paginate(10);
        return view('livestreams.index', compact('livestreams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = Auth::user()->role === 'admin' ? User::all() : collect([Auth::user()]);
        return view('livestreams.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLivestreamRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user_id ?? Auth::id();
        $data['slug'] = Livestream::generateUniqueSlug($data['title']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = Livestream::uploadThumbnail($request->file('thumbnail'));
        }

        Livestream::create($data);
        return redirect()->route('livestreams.index')->with('success', 'Livestream Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {

    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $livestream = Livestream::where('slug', $slug)->firstOrFail();
        $this->authorizeAction($livestream);

        $users = auth()->user()->role === 'admin' ? User::all() : collect([auth()->user()]);
        return view('livestreams.edit', compact('livestream', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLivestreamRequest $request)
    {
        $livestream = Livestream::where('slug', $request->slug)->firstOrFail();
        $this->authorizeAction($livestream);

        $data = $request->validated();
        $data['slug'] = Livestream::generateUniqueSlug($data['title'], $livestream->id);
        $data['user_id'] = $request->user_id ?? $livestream->user_id;
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('thumbnail')) {
            $livestream->deleteThumbnail();
            $data['thumbnail'] = Livestream::uploadThumbnail($request->file('thumbnail'));
        }

        $livestream->update($data);

        return redirect()->route('livestreams.index')->with('success', 'Livestream updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $livestream = Livestream::where('slug', $slug)->firstOrFail();
        $this->authorizeAction($livestream);
        $livestream->deleteThumbnail();
        $livestream->delete();

        return redirect()->route('livestreams.index')->with('success', 'Livestream deleted successfully!');
    }
    private function authorizeAction($livestream)
    {
        if (auth()->user()->role !== 'admin' && auth()->id() !== $livestream->user_id) {
            abort(403);
        }
    }
}
