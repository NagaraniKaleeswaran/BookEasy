<x-admin-layout>
    <x-slot name="header">
        Customer Details: {{ $customer->name }}
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Customers
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Customer Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 col-span-1">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-2xl mr-4">
                    {{ substr($customer->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $customer->name }}</h3>
                    <p class="text-sm text-slate-500">Customer since {{ $customer->created_at->format('M Y') }}</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Email</p>
                    <p class="text-sm text-slate-800">{{ $customer->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Phone</p>
                    <p class="text-sm text-slate-800">{{ $customer->phone ?? 'Not provided' }}</p>
                </div>
            </div>
        </div>

        <!-- Appointment History -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-0 col-span-1 md:col-span-2 flex flex-col">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-semibold text-slate-800">Appointment History</h3>
            </div>
            
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 tracking-wider">
                            <th class="px-6 py-3 font-semibold">Service</th>
                            <th class="px-6 py-3 font-semibold">Date & Time</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($appointments as $appointment)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-800">{{ optional($appointment->service)->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-800">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-100 text-amber-800',
                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-emerald-100 text-emerald-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $color = $statusColors[$appointment->status] ?? 'bg-slate-100 text-slate-800';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium capitalize {{ $color }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500 text-sm">
                                No past appointments found for this customer.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($appointments->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 mt-auto">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
