<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Mime\Header\all;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $request->request->add([
            'user_id' => Auth::id(),
        ]);
        $create = Feedback::create($request->all());
        if ($create) {
            return response()->json([
                'message' => 'feedback is added successful',
            ]);
        }
    }

    function GetFeedback()
    {
        $data = Feedback::with(['user','category'])->paginate(10);
        return response()->json($data);
    }

    function GeComment($id)
    {
        $data = Comment::with(['user','feedback'])->where('feedback_id',$id)->paginate(10);
        return response()->json($data);
    }
}
