<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @yield('head')
    <title>Port TV</title>
</head>

<body>
    <main class="container px-4 mx-auto">
        @yield('content')
    </main>
</body>

</html>