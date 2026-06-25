@extends('layouts.public')

@section('title', 'BookEasy - Contact Us')

@section('content')
<div class="bg-white py-16 px-4 overflow-hidden sm:px-6 lg:px-8 lg:py-24">
    <div class="relative max-w-xl mx-auto">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Contact Support</h2>
            <p class="mt-4 text-lg leading-6 text-slate-500">
                Have a question about our platform or need help with a booking? Send us a message and we'll get back to you shortly.
            </p>
        </div>
        <div class="mt-12" x-data="{
            name: '',
            email: '',
            message: '',
            errors: {},
            isSubmitting: false,
            isSuccess: false,
            redirectTimer: null,
            redirectCountdown: 8,
            
            validate() {
                this.errors = {};
                if (!this.name.trim()) this.errors.name = 'Full Name is required.';
                if (!this.email.trim()) {
                    this.errors.email = 'Email is required.';
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) {
                    this.errors.email = 'Please enter a valid email address.';
                }
                if (!this.message.trim()) this.errors.message = 'Message is required.';
                return Object.keys(this.errors).length === 0;
            },
            
            async submit() {
                if (!this.validate()) return;
                
                this.isSubmitting = true;
                
                // Simulate an API call delay for the portfolio experience
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                this.isSubmitting = false;
                this.isSuccess = true;
                
                this.startRedirectTimer();
            },
            
            startRedirectTimer() {
                this.redirectCountdown = 8;
                this.redirectTimer = setInterval(() => {
                    this.redirectCountdown--;
                    if (this.redirectCountdown <= 0) {
                        this.resetForm();
                    }
                }, 1000);
            },
            
            resetForm() {
                if (this.redirectTimer) clearInterval(this.redirectTimer);
                this.isSuccess = false;
                this.name = '';
                this.email = '';
                this.message = '';
                this.errors = {};
            }
        }">
            
            <!-- Success State -->
            <div x-show="isSuccess" x-cloak 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-6" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="rounded-2xl bg-white shadow-xl p-8 sm:p-10 text-center border border-slate-100 relative overflow-hidden">
                
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-4 tracking-tight">Message Sent Successfully</h3>
                
                <p class="text-base sm:text-lg text-slate-600 mb-2 leading-relaxed">
                    Thank you for reaching out. Your message has been received successfully. We appreciate your interest in BookEasy.
                </p>
                
                <p class="text-xs text-slate-400 mb-8 italic">
                    This is a portfolio demonstration. Messages are not actively monitored.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-8">
                    <a href="{{ route('home') }}" @click="if(redirectTimer) clearInterval(redirectTimer)" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Back to Home
                    </a>
                    <button @click="resetForm" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-slate-300 rounded-md shadow-sm text-base font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Send Another Message
                    </button>
                </div>

                <p class="text-sm text-slate-500">
                    Returning to the contact page in <span x-text="redirectCountdown" class="font-semibold text-slate-700"></span> seconds...
                </p>
            </div>

            <!-- Contact Form -->
            <form x-show="!isSuccess" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @submit.prevent="submit" class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8 bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-slate-100">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-slate-700">Full Name</label>
                    <div class="mt-1 relative">
                        <input type="text" x-model="name" id="name" autocomplete="name" 
                            :class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500': errors.name, 'border-slate-300 focus:ring-indigo-500 focus:border-indigo-500': !errors.name}"
                            class="py-3 px-4 block w-full shadow-sm rounded-md border transition-colors">
                    </div>
                    <p x-show="errors.name" x-text="errors.name" x-cloak class="mt-2 text-sm text-red-600 font-medium"></p>
                </div>
                
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                    <div class="mt-1 relative">
                        <input type="email" x-model="email" id="email" autocomplete="email" 
                            :class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500': errors.email, 'border-slate-300 focus:ring-indigo-500 focus:border-indigo-500': !errors.email}"
                            class="py-3 px-4 block w-full shadow-sm rounded-md border transition-colors">
                    </div>
                    <p x-show="errors.email" x-text="errors.email" x-cloak class="mt-2 text-sm text-red-600 font-medium"></p>
                </div>
                
                <div class="sm:col-span-2">
                    <label for="message" class="block text-sm font-medium text-slate-700">Message</label>
                    <div class="mt-1 relative">
                        <textarea id="message" x-model="message" rows="4" 
                            :class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500': errors.message, 'border-slate-300 focus:ring-indigo-500 focus:border-indigo-500': !errors.message}"
                            class="py-3 px-4 block w-full shadow-sm rounded-md border transition-colors"></textarea>
                    </div>
                    <p x-show="errors.message" x-text="errors.message" x-cloak class="mt-2 text-sm text-red-600 font-medium"></p>
                </div>
                
                <div class="sm:col-span-2 mt-2">
                    <button type="submit" :disabled="isSubmitting" 
                        class="w-full flex items-center justify-center px-6 py-4 border border-transparent rounded-md shadow-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-75 disabled:cursor-not-allowed transition-all">
                        
                        <!-- Loading Spinner -->
                        <svg x-show="isSubmitting" x-cloak class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        
                        <span x-text="isSubmitting ? 'Sending...' : 'Send Message'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
