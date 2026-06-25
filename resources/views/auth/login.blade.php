<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookEasy - Admin Login</title>
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
<body class="font-sans text-slate-900 antialiased bg-slate-50 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <!-- Logo -->
        <div class="flex justify-center mb-2">
            <x-application-logo class="h-16 w-auto text-slate-900" />
        </div>
        <h2 class="text-center text-lg font-medium text-slate-500">
            Smart Appointment Booking Platform
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        
        <!-- Demo Credentials Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 shadow-sm mx-4 sm:mx-0">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-semibold text-blue-800">Demo Credentials</h3>
                    <p class="text-sm text-blue-600 mt-1">Admin Login</p>
                </div>
                <button onclick="copyCredentials(event)" class="inline-flex items-center px-3 py-1.5 border border-blue-300 shadow-sm text-xs font-medium rounded text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Copy Credentials
                </button>
            </div>
            <div class="mt-3 text-sm text-blue-700 font-mono bg-blue-100 p-3 rounded border border-blue-200">
                <div>Email: <a href="mailto:admin@bookeasy.com" id="demo-email" class="font-bold hover:underline">admin@bookeasy.com</a></div>
                <div class="mt-2">Password: <span id="demo-pass" class="font-bold">password</span></div>
            </div>
        </div>

        <!-- Login Form -->
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 mx-4 sm:mx-0 border border-slate-200">
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required autofocus value="{{ old('email') }}" class="appearance-none block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-slate-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Forgot your password?
                            </a>
                        @endif
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-footer />

    <!-- Script to copy credentials -->
    <script>
        function copyCredentials(event) {
            const email = document.getElementById('demo-email').innerText;
            const pass = document.getElementById('demo-pass').innerText;
            
            // Autofill the form inputs directly for user convenience
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
            
            // Try to copy to clipboard 
            navigator.clipboard.writeText(`Email: ${email}\nPassword: ${pass}`).then(() => {
                const btn = event.currentTarget;
                const originalHTML = btn.innerHTML;
                
                // Visual feedback
                btn.innerHTML = `<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Copied!`;
                btn.classList.add('bg-green-50', 'text-green-700', 'border-green-300');
                btn.classList.remove('bg-white', 'text-blue-700', 'border-blue-300');
                
                // Reset after 2 seconds
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('bg-green-50', 'text-green-700', 'border-green-300');
                    btn.classList.add('bg-white', 'text-blue-700', 'border-blue-300');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }
    </script>
</body>
</html>
