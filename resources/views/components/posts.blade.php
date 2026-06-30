@push('styles')
    @vite('resources/css/posts.css')
@endpush

<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>

<div class="create-post-wrapper container my-5">
    @auth
        <form action="{{ route('posts.store') }}" method="POST" class="create-post-form">
            @csrf
            <h3 class="gradient-text text-center">Create a post!</h3>
            <div class="d-flex flex-column align-items-center w-100 gap-3">
                <input type="text" name="title" placeholder="Write a title..." required>
                <textarea name="content" placeholder="Write a post..." maxlength="254" required></textarea>
                <input type="text" name="image" placeholder="Send Image Url(optinal)">
                <button type="submit" class="btn-submit mt-2" aria-label="Submit post">
                    <i class="bi bi-send"></i> Send
                </button>
            </div>
        </form>
    @endauth
</div>

<div class="posts-feed-fullscreen">
    @foreach ($posts as $post)
        <article class="post-fullscreen d-flex flex-column justify-content-center" id="post-{{ $post->id }}">
            
            <header class="post-header-floating mb-5 text-center mt-4">
                <h2 class="post-title">{{ $post->title }}</h2>
                <div class="post-meta d-flex justify-content-center gap-3">
                    <span class="author"><i class="bi bi-person"></i> {{ $post->user->username }}</span>
                    <span class="date"><i class="bi bi-clock"></i> {{ $post->created_at->format('F j, Y, g:i a') }}</span>
                    
                    @auth
                        @if (auth()->user()->id === $post->user_id)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" title="Delete Post" aria-label="Delete post">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </header>

            <div class="container-fluid px-3 px-xl-5 w-100 flex-grow-1 d-flex align-items-center pb-5">
                <div class="row align-items-center justify-content-between w-100 m-0">
                    
                    <div class="col-12 col-lg-3 text-start px-0 content-col mb-4 mb-lg-0">
                        <div class="pe-3">
                            <p class="post-content-text">{{ $post->content }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 text-center d-flex justify-content-center align-items-center image-col mb-4 mb-lg-0 p-0">
                        <div class="natural-image-container">
                            <img src="{{ $post->image }}" 
                                 class="img-fluid floating-img thief-target" 
                                 crossOrigin="anonymous"
                                 alt="{{ $post->title }}">
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 px-0 comments-col text-end">
                        <button class="btn-toggle-comments text-end w-100 bg-transparent border-0 text-light fw-bold" 
                                onclick="toggleComments({{ $post->id }})" 
                                aria-label="Show comments"
                                aria-expanded="false"
                                aria-controls="comments-section-{{ $post->id }}">
                            Comments <i class="bi bi-chat-dots ms-2"></i>
                        </button>

                        <div id="comments-section-{{ $post->id }}" class="comments-container text-start mt-3">
                            <div class="comments-list">
                                @foreach ($post->comments as $comment)
                                    <div class="comment-item">
                                        <div class="comment-header d-flex justify-content-between align-items-center">
                                            <strong>{{ $comment->user->username }}</strong>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="comment-date">{{ $comment->created_at->format('M j, g:i a') }}</span>
                                                @auth
                                                    @if (auth()->user()->id === $comment->user_id)
                                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="m-0 p-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-delete small" title="Delete comment" aria-label="Delete comment">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                        <p class="comment-text">{{ $comment->content }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <form action="{{ route('comments.store') }}" method="POST" class="add-comment-form d-flex gap-2 mt-2">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <textarea name="content" placeholder="Write a comment..." required class="w-100 bg-transparent text-light" aria-label="Comment text"></textarea>
                                <button type="submit" class="btn-submit small" aria-label="Submit comment" title="Send">
                                    <i class="bi bi-send"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    @endforeach
</div>

<script>
    // Consistent toggle combining CSS opacity and JS display block via classes
    function toggleComments(postId) {
        const section = document.getElementById(`comments-section-${postId}`);
        const button = document.querySelector(`[aria-controls="comments-section-${postId}"]`);
        
        if (section.classList.contains('show')) {
            // Start fade out
            section.classList.remove('visible');
            button.setAttribute('aria-expanded', 'false');
            
            // Wait for the CSS transition time to remove from DOM flow
            section.addEventListener('transitionend', function handler() {
                section.classList.remove('show');
                section.removeEventListener('transitionend', handler);
            });
        } else {
            // Return to DOM flow
            section.classList.add('show');
            button.setAttribute('aria-expanded', 'true');
            
            // Force reflow to ensure the .show class renders before .visible triggers the CSS transition
            void section.offsetWidth; 
            
            // Start fade in
            section.classList.add('visible');
        }
    }

    // Dynamic Background Gradient Logic
    document.addEventListener("DOMContentLoaded", function () {
        const colorThief = new ColorThief();
        const images = document.querySelectorAll('.thief-target');

        images.forEach(img => {
            if (img.complete) {
                applyDynamicGradient(img);
            } else {
                img.addEventListener('load', function () {
                    applyDynamicGradient(img);
                });
            }
        });

        function applyDynamicGradient(img) {
            try {
                // ColorThief might fail if the image (like Imgur) denies CORS headers. 
                const dominantColor = colorThief.getColor(img);
                const r = dominantColor[0];
                const g = dominantColor[1];
                const b = dominantColor[2];

                const postArticle = img.closest('.post-fullscreen');
                if (postArticle) {
                    // Color separation for perfect glow vs readable background
                    postArticle.style.setProperty('--gradient-color', `rgba(${r}, ${g}, ${b}, 0.15)`);
                    postArticle.style.setProperty('--shadow-color', `rgba(${r}, ${g}, ${b}, 0.65)`);
                    
                    // Add class to trigger the pseudo-element opacity transition smoothly
                    postArticle.classList.add('bg-loaded');
                }
            } catch (error) {
                console.warn("ColorThief blocked by CORS. Fallback maintained.", error);
            }
        }
    });
</script>