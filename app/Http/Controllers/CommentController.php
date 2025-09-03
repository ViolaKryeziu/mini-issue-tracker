<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Return paginated comments (JSON for AJAX)
     */
    public function index(Issue $issue, Request $request)
    {
        $comments = $issue->comments()->latest()->paginate(5);

        if ($request->ajax()) {
            $html = view('issues.partials.comments_list', compact('comments'))->render();

            return response()->json([
                'html'          => $html,
                'next_page_url' => $comments->nextPageUrl(),
            ]);
        }

        return view('issues.show', compact('issue', 'comments'));
    }

    public function store(StoreCommentRequest $request, Issue $issue)
    {
        $comment = $issue->comments()->create($request->validated());
        return response()->json($comment, 201);
    }
    
    
    
}
