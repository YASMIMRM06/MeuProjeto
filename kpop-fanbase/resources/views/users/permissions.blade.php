<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
{{ __('Manage Permissions for User: ') . $user->name }}
</h2>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('users.permissions.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <p class="mb-4 text-gray-600 dark:text-gray-400">
                            Select permissions for {{ $user->name }}. Users with type 'admin' automatically have all permissions.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($allPermissions as $permission)
                                <div class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}
                                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $permission->name }} <span class="text-gray-500 dark:text-gray-400 text-xs">({{ $permission->slug }})</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('permissions')" class="mt-2" />

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Permissions') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>