<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'review' => 'required|string|max:255',
        ]);

        $create = Comment::create([
            'user_id' => Auth::id(),
            'feedback_id' => $request->feedback_id,
            'content' => $request->review,
        ]);
        if ($create) {
            return response()->json([
                'message' => 'feedback is added successful',
            ]);
        }
    }
}
