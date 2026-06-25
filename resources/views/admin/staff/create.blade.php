<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Add Staff Member') }}
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-slate-900">
                <form method="POST" action="{{ route('admin.staff.store') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Phone (optional)')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Role -->
                        <div>
                            <x-input-label for="role" :value="__('Role')" />
                            <x-text-input id="role" class="block mt-1 w-full" type="text" name="role" :value="old('role')" required placeholder="e.g. Senior Stylist, Consultant" />
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.staff.index') }}" class="text-sm text-slate-600 hover:text-slate-900 mr-4">Cancel</a>
                        <x-primary-button>
                            {{ __('Add Staff') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-admin-layout>
