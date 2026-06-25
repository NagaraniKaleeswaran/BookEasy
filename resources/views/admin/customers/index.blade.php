<x-admin-layout>
    <x-slot name="header">
        Customers
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="w-full sm:w-1/3 relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customers..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 tracking-wider">
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold">Phone</th>
                        <th class="px-6 py-4 font-semibold">Joined</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-800">{{ $customer->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ $customer->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ $customer->phone ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-500">{{ $customer->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-12 h-12 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p class="text-lg font-medium">No customers found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
