<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'comment' => 'required|string',
            'grade' => 'required|integer|min:1|max:5',
        ]);

        // Assuming 'user' is retrieved from authentication (e.g., Auth::user())
        $user = Auth::user();

        $review = new Review;
        $review->book_id = $bookId;
        $review->user_id = $user->id;
        $review->comment = $request->comment;
        $review->grade = $request->grade;
        $review->publish_date = now(); // Use Laravel's 'now()' helper for current date/time

        $review->save();

        // Optional: Flash a success message or redirect to a confirmation page

        return back();
    }
}
