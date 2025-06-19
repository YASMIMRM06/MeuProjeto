<?php

namespace App\Http\Controllers;

use App\Models\ExtendedProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the user's extended profile.
     */
    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's extended profile.
     */
    public function edit(User $user)
    {
        // Authorize that the authenticated user is editing their own profile or an admin
        $this->authorize('update', $user->extendedProfile ?? new ExtendedProfile(['user_id' => $user->id]));

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified user's extended profile in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user->extendedProfile ?? new ExtendedProfile(['user_id' => $user->id]));

        $request->validate([
            'bio' => 'nullable|string|max:1000',
            'social_networks' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'profile_picture' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // Update user basic info
        $user->fill($request->only('birth_date'));
        if ($request->hasFile('profile_picture')) {
            // Store the image and update the path
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
        $user->save();

        // Update or create extended profile
        $extendedProfile = $user->extendedProfile ?? new ExtendedProfile(['user_id' => $user->id]);
        $extendedProfile->fill($request->only('bio', 'social_networks'));
        $extendedProfile->save();

        return redirect()->route('profile.show', $user)->with('success', 'Profile updated successfully.');
    }
}