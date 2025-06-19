 <x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
{{ __('User Profile: ') . $user->name }}
</h2>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center space-x-6 mb-6">
                        @if ($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover shadow-lg">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 text-6xl">
                                <i class="fa-solid fa-user-circle"></i> {{-- Or a simple initial --}}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-3xl font-bold">{{ $user->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                            <p class="text-gray-600 dark:text-gray-400 capitalize">{{ $user->type }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg mb-2"><strong>Birth Date:</strong> {{ $user->birth_date?->format('M d, Y') ?? 'N/A' }}</p>
                        @if ($user->extendedProfile)
                            <p class="text-lg mb-2"><strong>Bio:</strong> {{ $user->extendedProfile->bio ?? 'N/A' }}</p>
                            <p class="text-lg mb-2"><strong>Social Networks:</strong> {{ $user->extendedProfile->social_networks ?? 'N/A' }}</p>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">No extended profile information available.</p>
                        @endif
                    </div>

                    <hr class="my-6 border-gray-300 dark:border-gray-600">

                    <h3 class="text-xl font-semibold mb-3">User Permissions</h3>
                    @if ($user->permissions->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">This user has no specific permissions assigned.</p>
                    @else
                        <ul class="list-disc list-inside">
                            @foreach ($user->permissions as $permission)
                                <li>{{ $permission->name }} ({{ $permission->slug }})</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-6 flex justify-end">
                        @if (Auth::id() === $user->id || Auth::user()->isOfType('admin'))
                            <a href="{{ route('profile.edit', $user) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit Profile</a>
                        @endif
                        @can('update', $user) {{-- Policy for managing other users --}}
                            <a href="{{ route('users.permissions', $user) }}" class="ml-4 text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">Manage Permissions</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>