@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Issues</h1>
        <a href="{{ route('issues.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">New Issue</a>
    </div>

    <form id="filters" method="GET" class="flex flex-wrap gap-2 mb-4">
        <select name="status" class="border p-2 rounded">
            <option value="">All status</option>
            <option value="open" {{ request('status')=='open'?'selected':'' }}>Open</option>
            <option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>In progress</option>
            <option value="closed" {{ request('status')=='closed'?'selected':'' }}>Closed</option>
        </select>

        <select name="priority" class="border p-2 rounded">
            <option value="">All priority</option>
            <option value="low" {{ request('priority')=='low'?'selected':'' }}>Low</option>
            <option value="medium" {{ request('priority')=='medium'?'selected':'' }}>Medium</option>
            <option value="high" {{ request('priority')=='high'?'selected':'' }}>High</option>
        </select>

        <select name="tag" class="border p-2 rounded">
            <option value="">All tags</option>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ (string)request('tag') === (string)$tag->id ? 'selected' : '' }}>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>

        <input id="searchInput" name="q" placeholder="Search..." class="border p-2 rounded flex-1 min-w-[200px]"
               value="{{ request('q') }}" autocomplete="off" />
    </form>

    <ul id="issuesList">
        @foreach($issues as $issue)
            <li class="p-3 bg-white rounded shadow mb-2">
                <a href="{{ route('issues.show', $issue) }}" class="font-semibold hover:underline">{{ $issue->title }}</a>
                <div class="text-sm text-gray-600">{{ optional($issue->project)->name }}</div>
                <div class="text-sm">Status: {{ $issue->status }} | Priority: {{ $issue->priority }}</div>
                <div class="flex gap-1 mt-1">
                    @foreach($issue->tags as $t)
                        <span class="text-xs px-2 py-0.5 rounded bg-gray-100">{{ $t->name }}</span>
                    @endforeach
                </div>
            </li>
        @endforeach
    </ul>

    <div class="mt-4" id="pagination">
        {{ $issues->links() }}
    </div>
</div>
@endsection
