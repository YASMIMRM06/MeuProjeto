<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store a newly created rating in storage.
     */
    public function store(Request $request, Music $music)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Check if the user has already rated this music
        $existingRating = Rating::where('user_id', Auth::id())
                                ->where('music_id', $music->id)
                                ->first();

        if ($existingRating) {
            return back()->with('error', 'You have already rated this music. Please update your existing rating.');
        }

        $rating = new Rating([
            'user_id' => Auth::id(),
            'music_id' => $music->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        $rating->save();

        $music->updateAverageRating(); // Update average rating on the music

        return back()->with('success', 'Your rating has been submitted successfully.');
    }

    /**
     * Update the specified rating in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        $this->authorize('update', $rating); // Ensure user can only update their own rating

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $rating->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $rating->music->updateAverageRating(); // Update average rating on the music

        return back()->with('success', 'Your rating has been updated successfully.');
    }

    /**
     * Remove the specified rating from storage.
     */
    public function destroy(Rating $rating)
    {
        $this->authorize('delete', $rating); // Ensure user can only delete their own rating
        $music = $rating->music;
        $rating->delete();
        $music->updateAverageRating(); // Update average rating on the music
        return back()->with('success', 'Your rating has been deleted.');
    }
}