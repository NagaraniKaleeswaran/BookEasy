<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Appointment Details') }} #{{ $appointment->id }}
            </h2>
            <a href="{{ route('admin.appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50">
                Back to List
            </a>
        </div>
    </x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Customer Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 border-b pb-2">Customer Information</h3>
                    <div class="space-y-3">
                        <p><span class="text-slate-500 font-medium">Name:</span> {{ $appointment->customer_name ?? $appointment->user->name }}</p>
                        <p><span class="text-slate-500 font-medium">Email:</span> <a href="mailto:{{ $appointment->customer_email ?? $appointment->user->email }}" class="text-indigo-600 hover:underline">{{ $appointment->customer_email ?? $appointment->user->email }}</a></p>
                        <p><span class="text-slate-500 font-medium">Phone:</span> {{ $appointment->customer_phone ?? $appointment->user->phone ?? 'N/A' }}</p>
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <a href="{{ route('admin.customers.show', $appointment->user_id) }}" class="text-sm text-indigo-600 font-semibold hover:underline">View Full Profile &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 border-b pb-2">Booking Details</h3>
                    <div class="space-y-3">
                        <p><span class="text-slate-500 font-medium">Service:</span> <span class="font-semibold">{{ $appointment->service->name }}</span> ({{ $appointment->service->duration }} mins)</p>
                        <p><span class="text-slate-500 font-medium">Date:</span> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</p>
                        <p><span class="text-slate-500 font-medium">Time:</span> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</p>
                        <p>
                            <span class="text-slate-500 font-medium">Status:</span> 
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $appointment->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:col-span-2">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 border-b pb-2">Appointment Notes</h3>
                    @if($appointment->notes)
                        <p class="text-slate-700 bg-slate-50 p-4 rounded border border-slate-200">{{ $appointment->notes }}</p>
                    @else
                        <p class="text-slate-500 italic">No notes provided by the customer.</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:col-span-2">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 border-b pb-2">Update Status</h3>
                    <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        @method('PUT')
                        <select name="status" class="block w-full max-w-xs pl-3 pr-10 py-2 text-base border-slate-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <x-primary-button>Update</x-primary-button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</x-admin-layout>
