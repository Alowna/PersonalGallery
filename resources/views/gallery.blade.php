@push('styles')
<link rel="stylesheet" href="http://[::1]:5173/resources/css/gallery.css">
@endpush

<x-layout>
    <main class="flex-grow-1">
        @guest
            <h1>Gallery</h1>
        @endguest

        @auth
            <h1>Enjoy the gallery, {{ auth()->user()->name}}!</h1>
        @endauth
        
        <div class="commentBox">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <textarea name="content" placeholder="Write a comment..." required></textarea>
                <button type="submit">Post Comment</button>
            </form>
        </div>

        <div class="comments">
            @foreach ($comments as $comment)
                <div class="comment">
                    <p class="text-white">{{ $comment->content }}</p>
                    <p class="comment-meta text-white">Posted by {{ $comment->user->username }} on {{ $comment->created_at->format('F j, Y, g:i a') }}</p>
                </div>
                @auth
                    @if (auth()->user()->id === $comment->user_id)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    @endif
                    @endauth
            @endforeach
        </div>
    </main>
</x-layout>