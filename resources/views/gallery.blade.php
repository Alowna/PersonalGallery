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
        
    <x-posts :posts="$posts" :comments="$comments" />
           






    </main>
</x-layout>