<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Group;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    /**
     * Display a listing of the music.
     */
    public function index()
    {
        $music = Music::with('group')->orderBy('title')->paginate(10);
        return view('music.index', compact('music'));
    }

    /**
     * Show the form for creating new music.
     */
    public function create()
    {
        $this->authorize('create', Music::class);
        $groups = Group::all();
        return view('music.create', compact('groups'));
    }

    /**
     * Store a newly created music in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Music::class);

        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'title' => 'required|string|max:255',
            'duration' => 'nullable|date_format:H:i:s',
            'youtube_link' => 'nullable|url|max:255',
            'release_date' => 'nullable|date',
        ]);

        Music::create($request->all());

        return redirect()->route('music.index')->with('success', 'Music added successfully.');
    }

    /**
     * Display the specified music.
     */
    public function show(Music $music)
    {
        return view('music.show', compact('music'));
    }

    /**
     * Show the form for editing the specified music.
     */
    public function edit(Music $music)
    {
        $this->authorize('update', $music);
        $groups = Group::all();
        return view('music.edit', compact('music', 'groups'));
    }

    /**
     * Update the specified music in storage.
     */
    public function update(Request $request, Music $music)
    {
        $this->authorize('update', $music);

        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'title' => 'required|string|max:255',
            'duration' => 'nullable|date_format:H:i:s',
            'youtube_link' => 'nullable|url|max:255',
            'release_date' => 'nullable|date',
        ]);

        $music->update($request->all());

        return redirect()->route('music.index')->with('success', 'Music updated successfully.');
    }

    /**
     * Remove the specified music from storage.
     */
    public function destroy(Music $music)
    {
        $this->authorize('delete', $music);
        $music->delete();
        return redirect()->route('music.index')->with('success', 'Music deleted successfully.');
    }
}