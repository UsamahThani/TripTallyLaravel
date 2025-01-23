<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicons/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="vendors/plyr/plyr.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('title') | {{ config('app.name') }}</title>
</head>

<body class="{{ Route::currentRouteName() === 'index' ? 'overflow-hidden' : '' }}">

    <main class="main" id="top">
        <nav class="navbar navbar-expand-lg fixed-top py-3 backdrop" data-navbar-on-scroll="data-navbar-on-scroll">
            <div class="container"><a class="navbar-brand d-flex align-items-center fw-bold fs-2" href="#"> <img
                        class="d-inline-block align-top img-fluid" src="{{ asset('img/gallery/logo-icon.png') }}"
                        alt="" width="50" /><span class="text-primary fs-4 ps-2">TripTally</span></a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse  mt-4 mt-lg-0" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto pt-2 pt-lg-0">
                        {{-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
                  <li class="nav-item"><a class="nav-link text-600" href="#featuresVideos">Video</a></li>
                  <li class="nav-item"><a class="nav-link text-600" href="#places">Destinations</a></li>
                  <li class="nav-item"><a class="nav-link text-600" href="#booking">Booking </a></li> --}}
                    </ul>
                    <div class="ps-lg-5 d-flex align-items-center">
                        <a href="" class="h-100 position-relative me-3">
                            <i class="fa-solid fa-cart-shopping fa-lg"></i>
                            <span
                                class="position-absolute top-20 start-90 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">items in cart</span>
                            </span>
                        </a>
                        <div class="dropdown">
                            <img src="{{ Auth::user()->avatar ?? asset('img/icons/user_avatar.jpg')}}" class="img-fluid dropbtn" onclick="dropdown()"
                                style="border-radius: 50%; cursor: pointer;" width="60rem" alt="">
                            <div id="myDropdown" class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#">Account Settings</a></li>
                                <li><a class="dropdown-item" href="#">Purchase History</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{route('logout')}}">Sign Out</a></li>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </nav>
        @yield('content')
    </main>

    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    @vite('resources/js/app.js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function dropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>

</html>
