@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-blue-100 via-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-xl p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Projects</h1>
            <a href="{{ route('projects.create') }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-black font-semibold py-2 px-4 rounded shadow">
                Create New Project
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <ul class="space-y-4">
            @foreach($projects as $project)
                <li class="bg-gray-50 p-4 rounded shadow flex justify-between items-center">
                    <div>
                        <a href="{{ route('projects.show', $project) }}" class="text-lg font-semibold text-gray-800 hover:underline">
                            {{ $project->name }}
                        </a>
                        <p class="text-gray-600">{{ $project->description }}</p>
                        <p class="text-gray-500 text-sm">
                            {{ $project->start_date ? $project->start_date->format('M d, Y') : '-' }} 
                            - 
                            {{ $project->deadline ? $project->deadline->format('M d, Y') : '-' }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('projects.edit', $project) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-black px-3 py-1 rounded shadow">
                            Edit
                        </a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this project?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-black px-3 py-1 rounded shadow">
                                Delete
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
