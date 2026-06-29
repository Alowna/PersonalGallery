@push('styles')
    @vite('resources/css/posts.css')
@endpush

<!-- CREATE POSTS FOR TESTING, GONNA REPLACE FOR API LATER-->
        <div class="createPosts container d-flex m-0">
            @auth
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <div class="container mt-4 d-flex flex-column align-items-center text-center">
                        <h3>Create a post!</h3>
                        <input class="text-center" name="title" placeholder="Write a title..." required></input>
                        <br>
                        <textarea class="text-center mb-2" name="content" placeholder="Write a post..." maxlength="254" required></textarea>
                    </div>
                    <div class="container d-flex justify-content-end">
                        <button class="btn btn-post" type="submit">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                </form>
            @endauth
        </div>
<br>
<!--LOAD POSTS HERE -->
        <div class="posts container d-flex flex-column align-items-center">
            @foreach ($posts as $post)
                <div class="post row">
                    

                    <div class="post-item d-flex flex-column align-items-start p-0 col">
                        <div class="title">
                            <p>{{ $post->title}}</p>
                            @auth
                                @if (auth()->user()->id === $post->user_id)
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button m-2"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    <p class="post-meta text-white">{{ $post->user->username }}</p>

                    <p class="post-content">{{ $post->content}} </p>

                    <p class="post-meta created-at"> {{ $post->created_at->format('F j, Y, g:i a') }} </p>
                    </div>
                   
                    
                    <div class="comments col">
                        <button
                                class="btn btn-comments collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#comments-{{ $post->id }}"
                                aria-expanded="false"
                                aria-controls="comments-{{ $post->id }}"
                                >
                            <i class="bi bi-chat-dots"></i> Comments
                        </button>

                        <div id="comments-{{ $post->id }}" class="collapse">
                            @foreach ($comments->where('post_id', $post->id) as $comment)
                            
                                <p class="text-white">
                                    {{ $comment->user->username }}: <br>{{ $comment->content }}
                                    <br>
                                    on {{ $comment->created_at->format('F j, Y, g:i a') }}
                                </p>
                                
                                @auth
                                    @if (auth()->user()->id === $comment->user_id)
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-button"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                @endauth
                            @endforeach
                        </div>
                </div>

            </div>


                <div class="commentBox mb-5">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <textarea name="content" placeholder="Write a comment..." required></textarea>
                        <button class="btn btn-post" type="submit">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>
                </div>


                    
             @endforeach
        </div>