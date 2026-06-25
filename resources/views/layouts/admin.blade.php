<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BookEasy') }} - Admin</title>

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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Backdrop -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-slate-900/50 transition-opacity lg:hidden" @click="sidebarOpen = false" x-transition.opacity></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-indigo-900 text-white transition duration-300 transform lg:static lg:translate-x-0 lg:inset-0">
            <div class="flex items-center justify-center h-16 bg-indigo-950 px-4">
                <a href="{{ route('admin.dashboard') }}">
                    <x-application-logo class="block h-10 w-auto text-white" />
                </a>
            </div>
            
            <nav class="mt-5 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800 rounded-lg' : 'hover:bg-indigo-800 rounded-lg transition-colors' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.appointments.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.appointments.*') ? 'bg-indigo-800 rounded-lg' : 'hover:bg-indigo-800 rounded-lg transition-colors' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Appointments
                </a>
                <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.customers.*') ? 'bg-indigo-800 rounded-lg' : 'hover:bg-indigo-800 rounded-lg transition-colors' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Customers
                </a>
                <a href="{{ route('admin.services.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.services.*') ? 'bg-indigo-800 rounded-lg' : 'hover:bg-indigo-800 rounded-lg transition-colors' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Services
                </a>
                <a href="{{ route('admin.staff.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.staff.*') ? 'bg-indigo-800 rounded-lg' : 'hover:bg-indigo-800 rounded-lg transition-colors' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Staff
                </a>
                <a href="{{ route('admin.staff-availability.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.staff-availability.*') ? 'bg-indigo-800 rounded-lg' : 'hover:bg-indigo-800 rounded-lg transition-colors' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Staff Availability
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-slate-500 focus:outline-none lg:hidden mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="text-xl font-semibold text-slate-800">{{ $header ?? 'Dashboard' }}</h2>
                </div>
                
                <div class="flex items-center" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center focus:outline-none">
                        <span class="mr-2 text-sm font-medium text-slate-700">{{ Auth::user()->name }}</span>
                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>

                    <div x-show="dropdownOpen" x-cloak @click.outside="dropdownOpen = false" @keydown.escape.window="dropdownOpen = false" x-transition class="absolute right-6 top-16 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10 border border-slate-100">
                        <a href="{{ route('profile.edit') }}" @click="dropdownOpen = false" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Profile Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" @click="dropdownOpen = false" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Log out</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6 flex flex-col">
                <!-- Session Status / Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 p-4 rounded-md bg-green-50 border border-green-200 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 rounded-md bg-red-50 border border-red-200 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex-grow">
                    {{ $slot }}
                </div>

                <x-footer />
            </main>
        </div>
    </div>
</body>
</html>
