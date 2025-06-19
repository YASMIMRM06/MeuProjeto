<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit KPOP Group: ') . $group->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('groups.update', $group) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Group Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $group->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="formation_date" :value="__('Formation Date')" />
                            <x-text-input id="formation_date" class="block mt-1 w-full" type="date" name="formation_date" :value="old('formation_date', $group->formation_date?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('formation_date')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="company" :value="__('Company')" />
                            <x-text-input id="company" class="block mt-1 w-full" type="text" name="company" :value="old('company', $group->company)" />
                            <x-input-error :messages="$errors->get('company')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea id="description" class="block mt-1 w-full" name="description">{{ old('description', $group->description) }}</x-textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        @if ($group->photo)
                            <div class="mt-4">
                                <x-input-label :value="__('Current Photo')" />
                                <img src="{{ asset('storage/' . $group->photo) }}" alt="{{ $group->name }}" class="w-32 h-32 object-cover rounded-lg mt-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Leave blank to keep current photo.</p>
                            </div>
                        @endif

                        <div class="mt-4">
                            <x-input-label for="photo" :value="__('Upload New Group Photo')" />
                            <input id="photo" type="file" name="photo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Group') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>