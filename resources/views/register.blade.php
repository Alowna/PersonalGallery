@push('styles')
<link rel="stylesheet" href="http://[::1]:5173/resources/css/login.css">
@endpush

<x-layout>
    <main class="flex-grow-1">
        <section class="ftco-section">

            <div class="container login">
                <h1 class="text-center mb-4">/Register!</h1>

                <div class="row justify-content-center align-items-center entireform">

                    <div class="col-12 col-md-6 text-center img-form">
                        <img
                            referrerpolicy="no-referrer"
                            src="https://i.imgur.com/p0tpoVS.png"
                            class="img-fluid profile-img"
                            alt="Profile">
                    </div>

                    <div class="col-12 col-md-6 loginform">
                        <form action="{{route('auth.register')}}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <input
                                    type="name"
                                    id="name"
                                    name="name"
                                    required
                                    placeholder="Name"
                                    class="custom-input">
                            </div>

                            <div class="mb-3">
                                <input
                                    type="username"
                                    id="username"
                                    name="username"
                                    required
                                    placeholder="Username"
                                    class="custom-input">
                            </div>



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

                            <div class="mb-3">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    placeholder="Confirm Password"
                                    class="custom-input">
                            </div>

                            <div class="mb-3">
                                <select
                                    id="gender"
                                    name="gender"
                                    onchange="toggleGenderOther(this)"
                                    class="custom-input"
                                >
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3" id="genderOtherContainer" style="display: none;">
                                <input 
                                    type="text" 
                                    id="genderOther"
                                    name="gender_other"
                                    placeholder="Please specify"
                                    class="custom-input"
                                >
                            </div>

                            <button
                                class="btn btn-dark custom-btn w-100"
                                type="submit">
                                Register
                            </button>

                            @error('username')
                                <p class="error">{{ $message }}</p>
                            @enderror

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
    <script>
        function toggleGenderOther(selectElement) {
            const otherContainer = document.getElementById('genderOtherContainer');
            const otherInput = document.getElementById('genderOther');
            
            if (selectElement.value === 'other') {
                otherContainer.style.display = 'block';
                otherInput.focus();
            } else {
                otherContainer.style.display = 'none';
                otherInput.value = '';
            }
        }

        // garante consistência no submit (SEM alterar select)
        document.querySelector('form').addEventListener('submit', function () {
            const genderSelect = document.getElementById('gender');
            const otherInput = document.getElementById('genderOther');

            // se for "other", força limpar gender e deixar só o texto
            if (genderSelect.value === 'other') {
                genderSelect.value = '';
            }
        });
        </script>
</x-layout>