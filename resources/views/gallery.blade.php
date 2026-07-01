@push('styles')
<link rel="stylesheet" href="http://[::1]:5173/resources/css/gallery.css">
@endpush

<x-layout>
    <main class="flex-grow-1">

        
    <x-posts :posts="$posts" :comments="$comments" />
           






    </main>
</x-layout>