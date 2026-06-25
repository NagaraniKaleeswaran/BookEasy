@extends('layouts.public')

@section('title', 'BookEasy - Our Services')

@section('content')
<div class="bg-white py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Catalog</h2>
            <p class="mt-1 text-4xl font-extrabold text-slate-900 sm:text-5xl sm:tracking-tight lg:text-6xl">Our Services</p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-slate-500">Explore our wide range of premium services tailored just for you. Book an appointment today.</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @php
            // For the static public page, we fetch active services directly from DB.
            $services = \App\Models\Service::where('status', 'active')->get();
        @endphp

        @forelse($services as $service)
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md transition duration-150">
                <div class="flex justify-between items-start">
                    <h3 class="text-xl font-bold text-slate-900">{{ $service->name }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Available
                    </span>
                </div>
                <p class="mt-4 text-slate-500">{{ $service->description ?? 'No description available.' }}</p>
                <div class="mt-6 flex justify-between items-center border-t border-slate-100 pt-4">
                    <div class="flex flex-col">
                        <span class="text-sm text-slate-500">Duration</span>
                        <span class="font-semibold text-slate-900">{{ $service->duration }} mins</span>
                    </div>
                    <div class="flex flex-col text-right">
                        <span class="text-sm text-slate-500">Price</span>
                        <span class="font-bold text-indigo-600 text-lg">${{ number_format($service->price, 2) }}</span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('book') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Book Now
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-500">
                No active services currently available.
            </div>
        @endforelse
    </div>
</div>
@endsection
