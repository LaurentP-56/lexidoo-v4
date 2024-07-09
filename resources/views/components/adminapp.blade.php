<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Roboto&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/adminindex.css') }}" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bodybg2">
    <div class="min-h-screen ">
        @include('components.adminnav')

        <!-- Page Heading -->
        @if (isset($header))
            <header class=" text-center shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
        var publicPath = "{{ asset('') }}";
    </script>
    <script src="{{ asset('/js/userlist.js') }}"></script>
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>

</html>
