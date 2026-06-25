@extends('layouts.public')

@section('title', 'BookEasy - Book Appointment')

@section('content')
<div class="bg-indigo-700">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 lg:flex lg:justify-between">
        <div class="max-w-xl">
            <h2 class="text-4xl font-extrabold text-white sm:text-5xl sm:tracking-tight lg:text-6xl">Ready to book?</h2>
            <p class="mt-5 text-xl text-indigo-200">
                The BookEasy mobile application is required to finalize an appointment. Experience a streamlined, native booking process directly on your phone.
            </p>
        </div>
        <div class="mt-10 w-full max-w-sm lg:mt-0">
            <div class="bg-white rounded-lg shadow-xl p-8">
                <h3 class="text-lg font-medium text-slate-900 text-center mb-6">Download the App</h3>
                <div class="space-y-4">
                    <div>
                        <a href="{{ asset('downloads/BookEasy-v1.0.apk') }}" download class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-slate-900 hover:bg-slate-800">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                            Get for Android (APK)
                        </a>
                        <p class="text-xs text-slate-500 text-center mt-2">
                            • Android 8.0+ &nbsp; • APK Size: ~56.3 MB &nbsp; • Latest Version: v1.0
                        </p>
                    </div>
                    <a href="{{ route('services') }}" class="w-full flex items-center justify-center px-4 py-3 border border-slate-300 shadow-sm text-base font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50">
                        Browse Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-slate-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold text-slate-900">How it works</h2>
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto text-xl font-bold mb-4">1</div>
                <h3 class="text-lg font-bold mb-2">Select a Service</h3>
                <p class="text-slate-500">Browse our catalog and pick the service you need.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto text-xl font-bold mb-4">2</div>
                <h3 class="text-lg font-bold mb-2">Pick a Time</h3>
                <p class="text-slate-500">Our app intelligently calculates available slots to prevent double booking.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto text-xl font-bold mb-4">3</div>
                <h3 class="text-lg font-bold mb-2">Confirm & Relax</h3>
                <p class="text-slate-500">You're all set! Track your appointments inside the app.</p>
            </div>
        </div>
    </div>
</div>
@endsection
