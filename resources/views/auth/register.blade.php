@extends('layout.auth')

@section('title', 'Register')

@section('content')
    <main id="top">
        <div id="particles-js" class="position-absolute overflow-hidden top-0 start-0 w-100 h-100"></div>
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card shadow-lg p-3 w-100" style="max-width: 400px; background-color: rgba(255, 255, 255, 0.9);">
                <div class="card-body">
                    <h3 class="text-center mb-3">Register</h3>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                            <span class="input-group-text text-dark"><i class="fa-regular fa-envelope"></i></span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name"
                                required>
                            <span class="input-group-text text-dark"><i class="fa-regular fa-user"></i></span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>
                            <span class="input-group-text text-dark" id="show-pwd"><i class="fa-regular fa-eye"
                                    style="cursor: pointer; user-select: none;"></i></span>
                        </div>
                        <div class="strong-pwd w-100 p-2 mb-3 bg-100 rounded-3 justify-content-center"
                            style="display: none">
                            <div class="text-group">
                                <div class=" d-flex align-items-center mb-2 text-danger">
                                    <i class="fa-regular fa-circle-xmark me-3"></i>
                                    <span>Must have uppercase letters (A-Z)</span>
                                </div>
                                <div class="text-item d-flex align-items-center mb-2 text-danger">
                                    <i class="fa-regular fa-circle-xmark me-3"></i>
                                    <span>Must have lowercase letters (a-z)</span>
                                </div>
                                <div class="text-item d-flex align-items-center mb-2 text-danger">
                                    <i class="fa-regular fa-circle-xmark me-3"></i>
                                    <span>Must have numbers (0-9)</span>
                                </div>
                                <div class="text-item d-flex align-items-center mb-2 text-danger">
                                    <i class="fa-regular fa-circle-xmark me-3"></i>
                                    <span>Special characters</span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3" id="rePasswordDiv">
                            <input type="password" class="form-control" id="rePassword" name="rePassword"
                                placeholder="Confirm Password" required>
                            <span class="input-group-text text-dark" id="show-repwd"><i id="re-eye-icon"
                                    class="fa-regular fa-eye" style="cursor: pointer; user-select: none;"></i></span>
                        </div>
                        <button type="submit" id="btn-submit" class="btn btn-primary w-100">Sign Up</button>
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <span>-OR-</span>
                        </div>
                        <a href="{{ route('auth.google') }}" class="btn btn-danger w-100">Sign Up with <i
                                class="fa-brands fa-google"></i></a>

                </div>
                </form>
            </div>
        </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // declare variables
            const showPwd = document.querySelector('#show-pwd');
            const pwdInput = document.querySelector('input[name="password"]');
            const eyeIcon = document.querySelector('.fa-eye');
            const strongPwdDiv = document.querySelector('.strong-pwd');
            const textGroup = document.querySelector('.text-group');
            const btnSubmit = document.querySelector('#btn-submit');
            // confirm password component
            const reShowPwd = document.querySelector('#show-repwd');
            const rePwdInput = document.querySelector('input[name="rePassword"]');
            const reEyeIcon = document.querySelector('#re-eye-icon');

            // requirements for password
            const requirements = [{
                    regex: /[A-Z]/,
                    element: textGroup.querySelector('div:nth-child(1)')
                },
                {
                    regex: /[a-z]/,
                    element: textGroup.querySelector('div:nth-child(2)')
                },
                {
                    regex: /[0-9]/,
                    element: textGroup.querySelector('div:nth-child(3)')
                },
                {
                    regex: /[^A-Za-z0-9]/,
                    element: textGroup.querySelector('div:nth-child(4)')
                }
            ];

            // show password requirements
            pwdInput.addEventListener('focus', () => {
                $(strongPwdDiv).fadeIn(500, () => {
                    strongPwdDiv.style.display = 'flex';
                    btnSubmit.disabled = true;
                });
            });
            // hide password requirements
            pwdInput.addEventListener('blur', () => {
                $(strongPwdDiv).fadeOut(500, () => {
                    strongPwdDiv.style.display = 'none';
                });
            });

            // check password requirements
            pwdInput.addEventListener('input', () => {
                const value = pwdInput.value;
                requirements.forEach(req => {
                    if (req.regex.test(value)) {
                        req.element.querySelector('i').classList.remove('fa-circle-xmark');
                        req.element.querySelector('i').classList.add('fa-circle-check');
                        req.element.classList.remove('text-danger');
                        req.element.classList.add('text-success');
                        btnSubmit.disabled = false;
                    } else {
                        req.element.querySelector('i').classList.remove('fa-circle-check');
                        req.element.querySelector('i').classList.add('fa-circle-xmark');
                        req.element.classList.remove('text-success');
                        req.element.classList.add('text-danger');
                        btnSubmit.disabled = true;
                    }
                });
            });

            // show password
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

            // show confirm password
            reShowPwd.addEventListener('click', () => {
                if (rePwdInput.type === 'password') {
                    rePwdInput.type = 'text';
                    reEyeIcon.classList.remove('fa-eye');
                    reEyeIcon.classList.add('fa-eye-slash');
                } else {
                    rePwdInput.type = 'password';
                    reEyeIcon.classList.remove('fa-eye-slash');
                    reEyeIcon.classList.add('fa-eye');
                }
            });

            // check if password and confirm password match
            rePwdInput.addEventListener('input', () => {
                if (rePwdInput.value === pwdInput.value) {
                    rePwdInput.classList.remove('is-invalid');
                    rePwdInput.classList.add('is-valid');
                    pwdInput.classList.add('is-valid');
                    btnSubmit.disabled = false;
                } else {
                    btnSubmit.disabled = true;
                    pwdInput.classList.remove('is-valid');
                    rePwdInput.classList.remove('is-valid');
                    rePwdInput.classList.add('is-invalid');
                }
            });
        });
    </script>
@endsection
