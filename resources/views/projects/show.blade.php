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

        <!-- Issues Section -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">Issues</h2>
            <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-black font-semibold py-2 px-4 rounded shadow">
                Add New Issue
            </a>
        </div>

        @if($project->issues->isEmpty())
            <p class="text-gray-500">No issues have been added to this project yet.</p>
        @else
            <ul class="space-y-4">
                @foreach($project->issues as $issue)
                    <li class="bg-gray-50 p-4 rounded shadow flex justify-between items-center">
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
                        <a href="#" class="bg-blue-500 hover:bg-blue-600 text-black px-3 py-1 rounded shadow">
                            View
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
