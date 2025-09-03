<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\AttachTagRequest;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Http\Requests\StoreCommentRequest;

class IssueController extends Controller
{
    // List with filters: status, priority, tag
    public function index(Request $request)
    {
        $query = Issue::with(['project', 'tags']);
    
        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%')
                  ->orWhere('description', 'like', '%'.$request->q.'%');
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
    
        if ($request->filled('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('id', $request->tag);
            });
        }
    
        $issues = $query->paginate(10);
    
        if ($request->ajax()) {
            return response()->json([
                'issues' => $issues->map(function($issue){
                    return [
                        'id' => $issue->id,
                        'title' => $issue->title,
                        'status' => $issue->status,
                        'priority' => $issue->priority,
                        'project_name' => optional($issue->project)->name,
                        'tags' => $issue->tags->map(fn($t) => ['name' => $t->name])
                    ];
                })
            ]);
        }
    
        $tags = Tag::all();
        return view('issues.index', compact('issues', 'tags'));
    }
    

    public function create()
    {
        $projects = Project::all();
        $tags = Tag::all();
        return view('issues.create', compact('tags'));
    }

    public function store(StoreIssueRequest $request)
    {
        $issue = Issue::create($request->validated());
    
        if ($request->filled('tags')) {
            $issue->tags()->sync($request->tags);
        }
    
        $issue->load('tags');
    
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['issue' => $issue]);
        }
    
        return redirect()->route('issues.index')->with('success', 'Issue created successfully.');
    }
    

    public function show(Issue $issue)
    {
        $issue->load(['tags', 'comments' => function($q) {
            $q->latest()->paginate(10);
        }]);
        $tags = Tag::all();
        return view('issues.show', compact('issue', 'tags'));
    }

    public function edit(Issue $issue)
    {
        $projects = Project::all();
        $tags = Tag::all();
        return view('issues.edit', compact('issue', 'projects', 'tags'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        $issue->update($request->validated());
    
        if ($request->filled('tags')) {
            $issue->tags()->sync($request->tags); 
        } else {
            $issue->tags()->sync([]); 
        }
    
        return redirect()->route('issues.show', $issue)->with('success', 'Issue updated successfully.');
    }
    

    public function destroy(Issue $issue)
    {
        $issue->delete();
        return redirect()->route('issues.index')->with('success', 'Issue deleted successfully.');
    }
    public function attachTag(Request $request, Issue $issue)
{
    $tag = Tag::findOrFail($request->tag_id);
    $issue->tags()->syncWithoutDetaching($tag);
    return response()->json(['tag' => $tag]);
}

public function detachTag(Request $request, Issue $issue)
{
    $tag = Tag::findOrFail($request->tag_id);
    $issue->tags()->detach($tag);
    return response()->json(['tag' => $tag]);
}
public function search(Request $request)
{
    $query = $request->get('q', '');
    $status = $request->get('status');
    $priority = $request->get('priority');
    $tag = $request->get('tag');

    $issues = Issue::with('project', 'tags')
        ->when($query, fn($q) => $q->where('title', 'like', "%$query%")
                                     ->orWhere('description', 'like', "%$query%"))
        ->when($status, fn($q) => $q->where('status', $status))
        ->when($priority, fn($q) => $q->where('priority', $priority))
        ->when($tag, fn($q) => $q->whereHas('tags', fn($q2) => $q2->where('tags.id', $tag)))
        ->get();

    return response()->json(['issues' => $issues]);
}

}
