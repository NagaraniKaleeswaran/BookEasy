@extends('layouts.public')

@section('title', 'BookEasy - Home')

@section('content')
@php
    // Dynamically fetch actual screenshots uploaded to storage
    $files = [];
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists('uploads')) {
        $files = \Illuminate\Support\Facades\Storage::disk('public')->files('uploads');
    }
    
    // Filter out non-images
    $mockups = array_values(array_filter($files, function($file) {
        return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
    }));

    // Map mockups safely, using duplicates if less than 3 exist
    $mockupLeft = isset($mockups[0]) ? asset('storage/' . $mockups[0]) : '';
    $mockupCenter = isset($mockups[1]) ? asset('storage/' . $mockups[1]) : (isset($mockups[0]) ? asset('storage/' . $mockups[0]) : '');
    $mockupRight = isset($mockups[2]) ? asset('storage/' . $mockups[2]) : (isset($mockups[0]) ? asset('storage/' . $mockups[0]) : '');
@endphp

@php
    $files = [];
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists('uploads')) {
        $files = \Illuminate\Support\Facades\Storage::disk('public')->files('uploads');
    }
    $mockups = array_values(array_filter($files, function($file) {
        return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
    }));
    $mockupAssets = array_map(function($path) {
        return asset('storage/' . $path);
    }, $mockups);
@endphp

<!-- Hero Section -->
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-20 px-4 sm:px-6 lg:px-8">
            <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Appointments made</span>
                        <span class="block text-indigo-600 xl:inline">simple and elegant</span>
                    </h1>
                    <p class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        BookEasy is the all-in-one platform for managing services, staff, and appointments natively on the web and your mobile device.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('book') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                Book Appointment
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="{{ route('services') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                View Services
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Float Animation Styles -->
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed-1 { animation: float 6s ease-in-out infinite; animation-delay: 1.5s; }
        .animate-float-delayed-2 { animation: float 6s ease-in-out infinite; animation-delay: 3s; }
    </style>

    <!-- Premium Mobile Showcase -->
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 flex items-center justify-center px-4 overflow-hidden pt-12 lg:pt-0 pb-16 lg:pb-0 lg:-translate-y-8"
         x-data="{ 
             mockups: {{ json_encode($mockupAssets) }},
             currentIndex: 0,
             interval: null,
             start() {
                 if (this.mockups.length > 1) {
                     this.interval = setInterval(() => {
                         this.currentIndex = (this.currentIndex + 1) % this.mockups.length;
                     }, 4000);
                 }
             },
             stop() {
                 if (this.interval) clearInterval(this.interval);
             },
             getImage(offset) {
                 if (this.mockups.length === 0) return '';
                 return this.mockups[(this.currentIndex + offset) % this.mockups.length];
             }
         }"
         x-init="start()"
         @mouseenter="stop()"
         @mouseleave="start()">
        
        <template x-if="mockups.length > 0">
            <div class="relative w-full max-w-2xl h-[450px] sm:h-[520px] flex items-center justify-center">
                
                <!-- Left Phone (Visible on lg+) -->
                <div class="hidden lg:block absolute left-0 xl:left-4 z-10 animate-float-delayed-1">
                    <div class="w-[220px] h-[480px] bg-slate-900 rounded-[2.5rem] border-[10px] border-slate-900 shadow-[0_20px_40px_-12px_rgba(0,0,0,0.4)] transform -rotate-12 scale-90 transition-all duration-700 overflow-hidden opacity-[0.98] blur-[0.5px] hover:blur-none hover:opacity-100 hover:scale-95 cursor-pointer" @click="currentIndex = (currentIndex + 1) % mockups.length">
                        <div class="absolute top-0 inset-x-0 h-5 w-24 bg-slate-900 rounded-b-2xl mx-auto z-20 flex justify-center items-center">
                            <div class="w-8 h-1 bg-black rounded-full opacity-50"></div>
                        </div>
                        <img :src="getImage(1)" class="w-full h-full object-cover transition-opacity duration-700 bg-slate-100">
                    </div>
                </div>

                <!-- Right Phone (Visible on md+) -->
                <div class="hidden md:block absolute right-0 xl:right-4 z-20 md:left-1/2 md:translate-x-12 lg:left-auto lg:translate-x-0 animate-float-delayed-2">
                    <div class="w-[220px] h-[480px] bg-slate-900 rounded-[2.5rem] border-[10px] border-slate-900 shadow-[0_20px_40px_-12px_rgba(0,0,0,0.4)] transform rotate-12 scale-90 transition-all duration-700 overflow-hidden opacity-[0.98] blur-[0.5px] hover:blur-none hover:opacity-100 hover:scale-95 cursor-pointer" @click="currentIndex = (currentIndex + 2) % mockups.length">
                        <div class="absolute top-0 inset-x-0 h-5 w-24 bg-slate-900 rounded-b-2xl mx-auto z-20 flex justify-center items-center">
                            <div class="w-8 h-1 bg-black rounded-full opacity-50"></div>
                        </div>
                        <img :src="getImage(2)" class="w-full h-full object-cover transition-opacity duration-700 bg-slate-100">
                    </div>
                </div>

                <!-- Center Phone (Visible everywhere) -->
                <div class="absolute z-30 md:-translate-x-20 lg:translate-x-0 animate-float">
                    <div class="w-[250px] h-[520px] bg-slate-900 rounded-[3rem] border-[12px] border-slate-900 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.8)] transform transition-all duration-700 overflow-hidden">
                        <!-- Dynamic Island / Notch -->
                        <div class="absolute top-0 inset-x-0 h-6 w-32 bg-slate-900 rounded-b-3xl mx-auto z-20 flex justify-center items-center">
                            <div class="w-12 h-1.5 bg-black rounded-full opacity-60"></div>
                        </div>
                        <img :src="getImage(0)" class="w-full h-full object-cover transition-opacity duration-700 bg-slate-100">
                        <!-- Subtle Glass Glare -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent opacity-50 pointer-events-none"></div>
                    </div>
                </div>

            </div>
        </template>
    </div>
</div>

<!-- Features Section -->
<div class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Features</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                A better way to manage time
            </p>
            <p class="mt-4 max-w-2xl text-xl text-slate-500 lg:mx-auto">
                Everything you need to automate your scheduling and grow your business.
            </p>
        </div>

        <div class="mt-10">
            <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-x-8 md:gap-y-10">
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-slate-900">Native Mobile App</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500">
                        Book seamlessly from your Android or iOS device with our native Flutter application.
                    </dd>
                </div>
                
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-slate-900">Admin Dashboard</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500">
                        Manage your staff, track availability, and view daily metrics from a secure backend.
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-slate-900">Smart Scheduling</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500">
                        Let your clients easily book, reschedule, or cancel their appointments 24/7.
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-slate-900">Customer Management</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500">
                        Maintain detailed client histories, notes, and contact information seamlessly.
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-slate-900">Staff Availability</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500">
                        Manage your team's shifts, breaks, and personal time-off effortlessly.
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-slate-900">Analytics & Reports</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500">
                        Gain valuable insights into your revenue, popular services, and staff performance.
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
