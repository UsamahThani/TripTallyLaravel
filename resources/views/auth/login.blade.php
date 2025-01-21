<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Traveltelly Sign In </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="wrapper">
        <form action="fn_signin.php" method="POST">
            <div class="top-container">
                <h2>Sign In</h2>
                {{-- <div class="checkbox-wrapper-35">
                    <input value="Yes" name="isAdmin" id="switch" type="checkbox" class="switch" <?php echo $isAdmin; ?>>
                    <label for="switch">
                        <span class="switch-x-text">Log in as </span>
                        <span class="switch-x-toggletext">
                            <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel">Unchecked:
                                </span>User</span>
                            <span class="switch-x-checked"><span class="switch-x-hiddenlabel">Checked:
                                </span>Admin</span>
                        </span>
                    </label>
                </div> --}}
            </div>

            <div class="input-box">
                <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="input-box">
                <a href="{{route('auth.google')}}" class="btn btn-danger">Sign In Via <i class="fa-brands fa-google"></i></a>
            </div>
            <div class="input-box h-25" id="show-pwd">
                <i class="bi bi-eye-fill"></i><span id="pwd-text" style="cursor: pointer; user-select: none;">Show
                    Password</span>
            </div>
            <div class="input-box button">
                <input type="submit" value="Sign In Now">
            </div>
            <div class="text no-acc-text">
                <h3>Does not have an account? <a href="signup.php">Sign Up Now</a></h3>
            </div>
            <div class="text forgot-pwd">
                <h3>Forgot password? <a href="resetPassword.php">Reset Password</a></h3>
            </div>
        </form>
    </div>
    {{-- <script>
        // Add an event listener to the checkbox
        const switchCheckbox = document.getElementById("switch");
        const noAccText = document.querySelector(".no-acc-text");

        switchCheckbox.addEventListener("change", function () {
            if (this.checked) {
                noAccText.classList.add("hidden"); // Add hidden class
            } else {
                noAccText.classList.remove("hidden"); // Remove hidden class
            }
        });
    </script> --}}

    <script>
        // show password
        const showPwd = document.getElementById("show-pwd");
        const pwdText = document.getElementById("pwd-text");
        const pwdInput = document.querySelector("input[name='password']");
        const eyeIcon = document.querySelector(".bi-eye-fill");
        showPwd.addEventListener("click", function() {
            if (pwdInput.type === "password") {
                pwdInput.type = "text";
                pwdText.textContent = "  Hide Password";
                eyeIcon.classList.remove("bi-eye-fill");
                eyeIcon.classList.add("bi-eye-slash-fill");
            } else {
                pwdInput.type = "password";
                pwdText.textContent = "  Show Password";
                eyeIcon.classList.remove("bi-eye-slash-fill");
                eyeIcon.classList.add("bi-eye-fill");
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
