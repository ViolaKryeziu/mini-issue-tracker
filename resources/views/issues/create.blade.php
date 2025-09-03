@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">
    <h1 class="text-2xl mb-4 font-bold">Create New Issue</h1>

    <form action="{{ route('issues.store') }}" method="POST" class="space-y-3">
        @csrf

        <div>
            <label class="block mb-1">Project</label>
            <select name="project_id" class="border p-2 rounded w-full">
                @foreach($projects as $p)
                    <option value="{{ $p->id }}" {{ (int)old('project_id')===$p->id?'selected':'' }}>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>
            @error('project_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Title</label>
            <input type="text" name="title" class="border p-2 rounded w-full" value="{{ old('title') }}">
            @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Description</label>
            <textarea name="description" class="border p-2 rounded w-full">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block mb-1">Status</label>
                <select name="status" class="border p-2 rounded w-full">
                    <option value="open" {{ old('status')=='open'?'selected':'' }}>Open</option>
                    <option value="in_progress" {{ old('status')=='in_progress'?'selected':'' }}>In Progress</option>
                    <option value="closed" {{ old('status')=='closed'?'selected':'' }}>Closed</option>
                </select>
                @error('status') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1">Priority</label>
                <select name="priority" class="border p-2 rounded w-full">
                    <option value="low" {{ old('priority')=='low'?'selected':'' }}>Low</option>
                    <option value="medium" {{ old('priority')=='medium'?'selected':'' }}>Medium</option>
                    <option value="high" {{ old('priority')=='high'?'selected':'' }}>High</option>
                </select>
                @error('priority') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1">Due date</label>
                <input type="date" name="due_date" class="border p-2 rounded w-full" value="{{ old('due_date') }}">
                @error('due_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block mb-1">Tags</label>
            <select name="tags[]" multiple class="border p-2 rounded w-full">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-black px-4 py-2 rounded">Create Issue</button>
    </form>
</div>
@endsection
