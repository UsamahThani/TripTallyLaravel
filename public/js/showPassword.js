const showPwd = document.querySelector('.showPwd');
const pwdInput = document.querySelector('input[type="password"]');
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