<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the groups.
     */
    public function index()
    {
        $groups = Group::orderBy('name')->paginate(10);
        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new group.
     */
    public function create()
    {
        $this->authorize('create', Group::class);
        return view('groups.create');
    }

    /**
     * Store a newly created group in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Group::class);

        $request->validate([
            'name' => 'required|string|max:255|unique:groups',
            'formation_date' => 'nullable|date',
            'company' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $group = Group::create($request->except('photo'));

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('group_photos', 'public');
            $group->photo = $path;
            $group->save();
        }

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    /**
     * Display the specified group.
     */
    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified group.
     */
    public function edit(Group $group)
    {
        $this->authorize('update', $group);
        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified group in storage.
     */
    public function update(Request $request, Group $group)
    {
        $this->authorize('update', $group);

        $request->validate([
            'name' => 'required|string|max:255|unique:groups,name,' . $group->id,
            'formation_date' => 'nullable|date',
            'company' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $group->fill($request->except('photo'));
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($group->photo) {
                \Storage::disk('public')->delete($group->photo);
            }
            $path = $request->file('photo')->store('group_photos', 'public');
            $group->photo = $path;
        }
        $group->save();

        return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
    }

    /**
     * Remove the specified group from storage.
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);
        if ($group->photo) {
            \Storage::disk('public')->delete($group->photo);
        }
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }
}