<!-- resources/views/projects/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-blue-50 to-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl bg-white shadow-2xl rounded-3xl p-10 border border-gray-200">
        <h1 class="text-4xl font-bold text-center text-indigo-700 mb-10">Edit Project</h1>

        <form action="{{ route('projects.update', $project->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Project Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Project Name</label>
                <input type="text" name="name" value="{{ old('name', $project->name) }}"
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 transition duration-200">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Description</label>
                <textarea name="description" rows="5"
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 transition duration-200">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dates -->
            <div>
    <label class="block text-sm font-semibold text-gray-800 mb-2">Start Date</label>
    <input type="date" name="start_date" 
           value="{{ old('start_date', \Carbon\Carbon::parse($project->start_date)->format('Y-m-d')) }}"
           class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 transition duration-200">
    @error('start_date')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block text-sm font-semibold text-gray-800 mb-2">Deadline</label>
    <input type="date" name="deadline" 
           value="{{ old('deadline', \Carbon\Carbon::parse($project->deadline)->format('Y-m-d')) }}"
           class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 transition duration-200">
    @error('deadline')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>


            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-black font-bold py-4 px-6 rounded-2xl shadow-lg transition transform hover:-translate-y-1 duration-300">
                    Update Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
