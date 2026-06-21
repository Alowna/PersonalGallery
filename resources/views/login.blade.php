@push('styles')
<link rel="stylesheet" href="http://[::1]:5173/resources/css/login.css">
@endpush

<x-layout>
    <main class="flex-grow-1">
        <section class="ftco-section">

            <div class="container login">
                <h1 class="text-center mb-4">/Welcome!</h1>

                <div class="row justify-content-center align-items-center entireform">

                    <div class="col-12 col-md-6 text-center img-form">
                        <img
                            referrerpolicy="no-referrer"
                            src="https://i.imgur.com/p0tpoVS.png"
                            class="img-fluid profile-img"
                            alt="Profile">
                    </div>

                    <div class="col-12 col-md-6 loginform">
                        <form action="/login" method="POST">
                            @csrf


                            <div class="mb-3">
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    required
                                    placeholder="E-mail"
                                    class="custom-input">
                            </div>

                            <div class="mb-3">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="Password"
                                    class="custom-input">
                            </div>

                            <button
                                class="btn btn-dark custom-btn w-100"
                                type="submit">
                                Login
                            </button>
                            @error('email')
                            <p class="error">{{ $message }}</p>
                            @enderror
                            @error('password')
                            <p class="error">{{ $message }}</p>
                            @enderror

                        </form>
                    </div>

                </div>
            </div>

        </section>
    </main>
</x-layout>