<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicons/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('img/favicons/manifest.json') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


    <title>@yield('title') | {{ config('app.name') }}</title>
</head>

<body>
    @if (session('success') || session('error'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
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

    <main id="top">
        <nav class="navbar navbar-expand-lg fixed-top py-3 backdrop" data-navbar-on-scroll="data-navbar-on-scroll">
            <div class="container"><a class="navbar-brand d-flex align-items-center fw-bold fs-2"
                    href="{{ route('welcome') }}"> <img class="d-inline-block align-top img-fluid"
                        src="{{ asset('img/gallery/logo-icon.png') }}" alt="" width="50" /><span
                        class="text-primary fs-4 ps-2">TripTally</span></a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
                    {{-- <ul class="navbar-nav ms-auto pt-2 pt-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-600" href="#featuresVideos">Video</a></li>
                        <li class="nav-item"><a class="nav-link text-600" href="#places">Destinations</a></li>
                        <li class="nav-item"><a class="nav-link text-600" href="#booking">Booking </a></li>
                    </ul>
                    <div class="ps-lg-5">
                        <a href="{{ route('getLogin') }}" class="btn btn-lg btn-outline-primary order-0"
                            type="submit">Sign
                            In</a>
                    </div> --}}
                </div>
            </div>
        </nav>
        @yield('content')

    </main>


    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', '/particles.json', function() {
            console.log('Particles.js loaded.');
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
        });

        // disable right click on particles-js
        document.getElementById('particles-js').addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    @vite('resources/js/app.js')
</body>

</html>
