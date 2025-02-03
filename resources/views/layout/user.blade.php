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
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    @vite('resources/css/app.css')
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>@yield('title') | {{ config('app.name') }}</title>
</head>

<body class="{{ Route::currentRouteName() === 'index' ? 'overflow-hidden' : '' }}">
    @if (session('success') || session('error'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true"
                data-delay="5000">
                <div
                    class="toast-header {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : '') }} text-white">
                    <img src="{{ asset('img/favicons/favicon-32x32.png') }}" class="rounded me-2" alt="...">
                    <strong class="me-auto">{{ config('app.name') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    @if (session('success'))
                        {{ session('success') }}
                    @elseif (session('error'))
                        {{ session('error') }}
                    @endif
                </div>
            </div>
        </div>
    @endif
    <main class="main" id="top">
        <nav class="navbar navbar-expand-lg fixed-top py-3 backdrop default-navbar"
            data-navbar-on-scroll="data-navbar-on-scroll">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center fw-bold fs-2" href="{{ route('index') }}">
                    <img class="d-inline-block align-top img-fluid" src="{{ asset('img/gallery/logo-icon.png') }}"
                        alt="" width="50" /><span class="text-primary fs-4 ps-2">TripTally</span></a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse  mt-4 mt-lg-0" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto pt-2 pt-lg-0">
                        @if (session()->has('tripData'))
                            <li class="nav-item"><a
                                    class="nav-link {{ session('searchType') === 'Hotels' ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('trip.hotel') }}">Hotels</a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ session('searchType') === 'Attractions' ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('trip.poi') }}">Attractions</a>
                            </li>
                        @endif
                    </ul>
                    <div class="ps-lg-5 d-flex align-items-center">
                        <a href="{{ route('cart.index') }}" class="h-100 position-relative me-3">
                            <i class="fa-solid fa-cart-shopping fa-lg"></i>
                            @if (session('cartExists') && count(session('cartExists')) > 0)
                                <span
                                    class="position-absolute top-20 start-90 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">items in cart</span>
                                </span>
                            @endif
                        </a>

                        <div class="dropdown">
                            <img src="{{ Auth::user()->avatar ?? asset('img/icons/user_avatar.jpg') }}"
                                class="img-fluid dropbtn" onclick="dropdown()"
                                style="border-radius: 50%; cursor: pointer;" width="60rem" alt="">
                            <div id="myDropdown" class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#">Account Settings</a></li>
                                <li><a class="dropdown-item" href="#">Purchase History</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Sign Out</a></li>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    @vite('resources/js/app.js')

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

        document.addEventListener('DOMContentLoaded', function() {

            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled-navbar');
                    navbar.classList.remove('default-navbar');
                } else {
                    navbar.classList.add('default-navbar');
                    navbar.classList.remove('scrolled-navbar');
                }
            });

        });

        document.addEventListener('DOMContentLoaded', function() {
            var toast = document.getElementById('liveToast')
            var btnClose = document.querySelector('.btn-close')
            if (toast) {
                var bsToast = new bootstrap.Toast(toast)
                bsToast.show()
            }
            btnClose.addEventListener('click', function() {
                bsToast.hide()
            })

            var userAvatar = document.querySelector('.dropbtn');

            userAvatar.onerror = function() {
                this.src = "{{ asset('img/icons/user_avatar.jpg') }}";
            };
        });
    </script>
</body>

</html>
