@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-blue-100 via-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-8">

        <!-- Project Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $project->name }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('projects.edit', $project) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-black px-3 py-1 rounded shadow">
                    Edit Project
                </a>
                <form action="{{ route('projects.destroy', $project) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this project?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-black px-3 py-1 rounded shadow">
                        Delete Project
                    </button>
                </form>
            </div>
        </div>

        <!-- Project Details -->
        <div class="mb-8">
            <p class="text-gray-600 mb-2">{{ $project->description }}</p>
            <p class="text-gray-500 text-sm">
                Start: {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : '-' }}
                -
                Deadline: {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('M d, Y') : '-' }}
            </p>
        </div>

        <!-- Add Issue Form -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Add New Issue</h2>
            <form id="addIssueForm" action="{{ route('issues.store') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <div class="mb-2">
                    <input type="text" name="title" placeholder="Issue title" class="w-full border p-2 rounded">
                    <div class="text-red-500 text-sm" id="error-title"></div>
                </div>
                <div class="mb-2">
                    <textarea name="description" placeholder="Issue description" class="w-full border p-2 rounded"></textarea>
                    <div class="text-red-500 text-sm" id="error-description"></div>
                </div>
                <div class="flex gap-2 mb-2">
                    <select name="status" class="border p-2 rounded">
                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="closed">Closed</option>
                    </select>
                    <select name="priority" class="border p-2 rounded">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="mb-2">
                    <select name="tags[]" multiple class="border p-2 rounded w-full">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-black font-semibold py-2 px-4 rounded shadow">
                    Add Issue
                </button>
            </form>
        </div>

        <!-- Issues List -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Issues</h2>
            <ul id="issuesList" class="space-y-4">
                @foreach($project->issues as $issue)
                <li class="bg-gray-50 p-4 rounded shadow flex justify-between items-center" data-id="{{ $issue->id }}">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $issue->title }}</p>
                        <p class="text-gray-500 text-sm">Status: {{ $issue->status }}</p>
                        @if($issue->tags->isNotEmpty())
                        <div class="flex gap-2 mt-1">
                            @foreach($issue->tags as $tag)
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('issues.show', $issue) }}" class="bg-blue-500 hover:bg-blue-600 text-black px-3 py-1 rounded shadow">
                        View
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/projects.js') }}"></script>
@endsection
