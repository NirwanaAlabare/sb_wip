<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>SB WIP</title>

    @include('layouts.link')

    @yield('custom-link')
</head>
<body>
    @include('layouts.navbar')

    <main role="main" class="main flex-shrink-0 container-fluid mt-3">
        @yield('content')
    </main>

    @yield('footer')

    @include('layouts.script')

    @yield('custom-script')
</body>
</html>
