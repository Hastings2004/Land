<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'plot_id' => 'required|exists:plots,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $user = Auth::user();
        $plot = Plot::findOrFail($request->plot_id);

        // Authorization Check:
        // 1. Check if the user has a "completed" reservation for this plot.
        // $canReview = $user->reservations()
        //                   ->where('plot_id', $plot->id)
        //                   ->where('status', 'completed')
        //                   ->exists();

        // if (!$canReview) {
        //     return back()->with('review_error', 'Sorry, you can only review plots you have completed a reservation for. Complete your reservation to leave a review!');
        // }

        // 2. Check if the user has already reviewed this plot.
        $hasReviewed = $plot->reviews()->where('user_id', $user->id)->exists();

        if ($hasReviewed) {
            return back()->with('review_error', 'You have already submitted a review for this plot. Thank you for your feedback!');
        }

        Review::create([
            'user_id' => $user->id,
            'plot_id' => $plot->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
