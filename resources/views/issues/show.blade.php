@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">

    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold">{{ $issue->title }}</h1>
            <p class="text-gray-600">{{ $issue->project->name }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('issues.edit', $issue) }}" class="btn">Edit</a>
            <form action="{{ route('issues.destroy', $issue) }}" method="POST" onsubmit="return confirm('Delete issue?')">
                @csrf
                @method('DELETE')
                <button class="btn-danger">Delete</button>
            </form>
        </div>
    </div>

    <div class="mt-4 p-4 border rounded">
        <p>{{ $issue->description }}</p>
    </div>

 <div id="tagsContainer" class="flex gap-2 mt-4" data-issue-id="{{ $issue->id }}">
        @foreach($issue->tags as $tag)
            <span class="px-2 py-1 bg-gray-200 rounded flex items-center gap-1">
                {{ $tag->name }}
                <button class="detach-tag text-red-500" data-tag-id="{{ $tag->id }}" data-url="{{ route('issues.tags.detach', [$issue, $tag]) }}">x</button>
            </span>
        @endforeach
        <button id="openTagModal" class="btn ml-2">Manage Tags</button>
    </div>

       <div id="tagModal" class="hidden mt-4 p-4 border rounded bg-gray-100">
        <select id="availableTags" class="border p-2 rounded w-full">
            @foreach(\App\Models\Tag::all() as $t)
                <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
        </select>
        <button id="attachTagBtn" class="btn ml-2" data-url="{{ route('issues.tags.attach', $issue) }}">Attach Tag</button>
    </div>

    <div id="comment-list" class="mt-6 space-y-3">
    @include('issues.partials.comments_list', [
        'comments' => $issue->comments()->latest()->take(10)->get(),
        'issue' => $issue
    ])
</div>

</div>

@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush


@endsection