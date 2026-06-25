<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BookEasy - Simplified Scheduling')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" href="/favicon.ico">
    <link rel="manifest" href="/site.webmanifest">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <nav class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <x-application-logo class="h-10 w-auto text-slate-900" />
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="border-transparent text-slate-500 hover:border-indigo-500 hover:text-indigo-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                        <a href="{{ route('services') }}" class="border-transparent text-slate-500 hover:border-indigo-500 hover:text-indigo-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Services</a>
                        <a href="{{ route('contact') }}" class="border-transparent text-slate-500 hover:border-indigo-500 hover:text-indigo-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Contact</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium">Admin Login</a>
                    @endauth
                    <a href="{{ route('book') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Book Appointment</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <x-footer />
</body>
</html>
