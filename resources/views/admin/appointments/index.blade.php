<x-admin-layout>
    <x-slot name="header">
        Appointments
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="w-full sm:w-2/3 flex flex-col sm:flex-row gap-4">
            <div class="relative w-full sm:w-1/2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customer or service..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <select name="status" onchange="this.form.submit()" class="w-full sm:w-1/3 py-2 px-3 border border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 tracking-wider">
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Service</th>
                        <th class="px-6 py-4 font-semibold">Date & Time</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($appointments as $appointment)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-800">{{ optional($appointment->user)->name }}</p>
                            <p class="text-xs text-slate-500">{{ optional($appointment->user)->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-800">{{ optional($appointment->service)->name }}</p>
                            <p class="text-xs text-slate-500">{{ optional($appointment->service)->duration }} mins</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-800">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                            <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
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
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-sm border-slate-200 rounded-md py-1 px-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirm</option>
                                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Complete</option>
                                    <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-12 h-12 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-lg font-medium">No appointments found</p>
                                <p class="text-sm mt-1">Try adjusting your filters or search query.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appointments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
