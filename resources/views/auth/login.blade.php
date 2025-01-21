@extends('layout.auth')

@section('title', 'Register')

@section('content')
    <main id="top">
        <div id="particles-js" class="position-absolute overflow-hidden top-0 start-0 w-100 h-100"></div>
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card shadow-lg p-3 w-100 h-50" style="max-width: 400px; background-color: rgba(255, 255, 255, 0.9);">
                <div class="card-body">
                    <h3 class="text-center mb-3">Sign In</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>
                            <span class="input-group-text" id="show-pwd"><i class="fa-regular fa-eye"
                                    style="cursor: pointer; user-select: none;"></i></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="#" class="text-decoration-none">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <span>-OR-</span>
                        </div>
                        <a href="{{route('auth.google')}}" class="btn btn-danger w-100">Sign In with <i class="fa-brands fa-google"></i></a>
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <span>-OR-</span>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <span>Don't have an account?</span>
                            <a href="{{route('getRegister')}}" class="ms-1">Sign Up</a>
                        </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const showPwd = document.querySelector('#show-pwd');
            const pwdInput = document.querySelector('input[name="password"]');
            const eyeIcon = document.querySelector('.fa-eye');

            showPwd.addEventListener('click', () => {
                if (pwdInput.type === 'password') {
                    pwdInput.type = 'text';
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    pwdInput.type = 'password';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });
        });
    </script>
@endsection
