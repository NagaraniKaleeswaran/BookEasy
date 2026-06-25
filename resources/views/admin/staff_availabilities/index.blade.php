<x-admin-layout>
    <x-slot name="header">
        Staff Availability
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('admin.staff-availability.index') }}" method="GET" class="w-full sm:w-1/3 relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search staff name..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 tracking-wider">
                        <th class="px-6 py-4 font-semibold">Staff Member</th>
                        <th class="px-6 py-4 font-semibold">Day of Week</th>
                        <th class="px-6 py-4 font-semibold">Start Time</th>
                        <th class="px-6 py-4 font-semibold">End Time</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($availabilities as $availability)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-800">{{ optional($availability->staff)->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ $availability->day_of_week }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ \Carbon\Carbon::parse($availability->start_time)->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ \Carbon\Carbon::parse($availability->end_time)->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.staff-availability.destroy', $availability) }}" method="POST" class="inline" onsubmit="return confirm('Remove this availability slot?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500">
                                <p class="text-lg font-medium">No availability records found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($availabilities->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $availabilities->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
