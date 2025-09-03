@extends('layouts.app')

@section('content')
<div class="container ...">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl">Tags</h1>
        <button id="openTagModal" class="btn">New Tag</button>
    </div>

    <ul>
        @foreach($tags as $tag)
            <li class="p-2 mb-2 rounded border flex justify-between items-center">
                <span>{{ $tag->name }}</span>
                <span style="color: {{ $tag->color }}">{{ $tag->color }}</span>
            </li>
        @endforeach
    </ul>

    
    <div id="tagModal" class="hidden">
        <form id="tagForm" action="{{ route('tags.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Tag Name" class="border p-2 rounded w-full mb-2">
            <input type="color" name="color" class="w-full mb-2">
            <button type="submit" class="btn">Save Tag</button>
        </form>
    </div>
</div>
@endsection
