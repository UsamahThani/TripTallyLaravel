<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="{{asset('css/theme.css')}}" rel="stylesheet" />
    @vite('resources/css/app.css')

    <title>@yield('title') | {{config('app.name')}}</title>
</head>

<body>


    @yield('content')

    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', '/particles.json', function () {
            console.log('Particles.js loaded.');
        });
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    @vite('resources/js/app.js')
</body>

</html>
