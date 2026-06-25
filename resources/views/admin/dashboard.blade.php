<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Bookings</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalBookings }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Today's Bookings</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $todaysBookings }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Upcoming Appointments</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $upcomingAppointments }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Customers</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalCustomers }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Services</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalServices }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Staff</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalStaff }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-50 rounded-lg flex items-center justify-center text-pink-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Daily Bookings (Last 7 Days)</h3>
            <div id="dailyChart" class="w-full h-72"></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Monthly Bookings</h3>
            <div id="monthlyChart" class="w-full h-72"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Daily Chart
            var dailyOptions = {
                series: [{
                    name: 'Bookings',
                    data: @json($dailyBookingsData)
                }],
                chart: {
                    type: 'area',
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#4f46e5'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: @json($dailyBookingsLabels),
                }
            };

            var dailyChart = new ApexCharts(document.querySelector("#dailyChart"), dailyOptions);
            dailyChart.render();

            // Monthly Chart
            var monthlyOptions = {
                series: [{
                    name: 'Bookings',
                    data: @json($monthlyBookingsData)
                }],
                chart: {
                    type: 'bar',
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#3b82f6'],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '50%',
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: @json($monthlyBookingsLabels),
                }
            };

            var monthlyChart = new ApexCharts(document.querySelector("#monthlyChart"), monthlyOptions);
            monthlyChart.render();
        });
    </script>
</x-admin-layout>
