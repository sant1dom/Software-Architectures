@php
    $ar = explode(".", Route::currentRouteName());
	$controller = $ar[0];
	$auth = App\Models\Auth::$current;
@endphp
        <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Dashboard -
        @if (isset($title))
            {{ $title }}
        @elseif (isset($header))
            {{ $header }}
        @endif
    </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="stylesheet" href="/css/app.css">
    <script type="text/javascript" src="/js/app.js"></script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <main>
        <!-- Error Start -->
        @if (isset($error))
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $error }}
                </h2>
            </div>
        @endif
        <!-- Error End -->

        <!-- Main Start -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <x-other.logo class="block w-auto fill-current text-gray-800" style="width: 150px"/>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        <!-- Main End -->
    </main>
</div>
</body>
</html>
