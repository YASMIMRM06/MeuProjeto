<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit KPOP Music: ') . $music->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('musics.update', $music) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="group_id" :value="__('Group')" />
                            <select id="group_id" name="group_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">Select a Group</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group_id', $music->group_id) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('group_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $music->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="duration" :value="__('Duration (HH:MM:SS)')" />
                            <x-text-input id="duration" class="block mt-1 w-full" type="time" name="duration" step="1" :value="old('duration', $music->duration?->format('H:i:s'))" />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="youtube_link" :value="__('YouTube Link')" />
                            <x-text-input id="youtube_link" class="block mt-1 w-full" type="url" name="youtube_link" :value="old('youtube_link', $music->youtube_link)" />
                            <x-input-error :messages="$errors->get('youtube_link')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="release_date" :value="__('Release Date')" />
                            <x-text-input id="release_date" class="block mt-1 w-full" type="date" name="release_date" :value="old('release_date', $music->release_date?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('release_date')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Music') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>