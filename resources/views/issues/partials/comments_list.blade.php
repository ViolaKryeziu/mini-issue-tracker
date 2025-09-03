<div id="comment-list" class="mt-6 space-y-3">
    @foreach($comments as $comment)
        <div class="comment p-2 border rounded" id="comment-{{ $comment->id }}">
            <strong>{{ $comment->author_name }}</strong>
            <p>{{ $comment->body }}</p>
        </div>
    @endforeach
</div>

<!-- Add Comment Form -->
<form id="addCommentForm" data-action="{{ route('issues.comments.store', $issue) }}" class="mt-4 border p-3 rounded">
    @csrf
    <div class="mb-2">
        <input name="author_name" placeholder="Your name" class="border p-2 rounded w-full">
        <div class="text-red-500 text-sm" id="error-author_name"></div>
    </div>
    <div class="mb-2">
        <textarea name="body" placeholder="Write a comment" class="border p-2 rounded w-full"></textarea>
        <div class="text-red-500 text-sm" id="error-body"></div>
    </div>
    <button type="submit" class="btn">Add Comment</button>
</form>
@push('scripts')
<script src="{{ asset('js/comments.js') }}"></script>
@endpush
