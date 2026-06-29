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
        
<!-- CREATE POSTS FOR TESTING, GONNA REPLACE FOR API LATER-->
        <div class="createPosts">
            @auth
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea name="title" placeholder="Write a title..." required></textarea>
                    <textarea name="content" placeholder="Write a post..." required></textarea>
                    <button type="submit">Post</button>
                </form>
            @endauth
        </div>
<!--LOAD POSTS HERE -->
        <div class="posts">
            @foreach ($posts as $post)
                <div class="post">
                    <p class="text-white"> {{ $post->title}} </p>
                    <p class="text-white">{{ $post->content}} </p>
                    <p class="post-meta text-white">Posted by {{ $post->user->username }} on {{ $post->created_at->format('F j, Y, g:i a') }}</p>

                    @auth
                        @if (auth()->user()->id === $post->user_id)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        @endif
                        @endauth

                <div class="commentBox">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <textarea name="content" placeholder="Write a comment..." required></textarea>
                        <button type="submit">Post Comment</button>
                    </form>
                </div>

                <div class="comments">
                    @foreach ($comments->where('post_id', $post->id) as $comment)
                    <div class="comment">
                        <p class="text-white">{{ $comment->content }}</p>
                        <p class="comment-meta text-white">Commented by {{ $comment->user->username }} on {{ $comment->created_at->format('F j, Y, g:i a') }}</p>
                        @auth
                            @if (auth()->user()->id === $comment->user_id)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    @endforeach
                </div>
                    
                </div>
             @endforeach
        </div>
           






    </main>
</x-layout>