<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('KPOP Groups') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('create', App\Models\Group::class)
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('groups.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Add New Group
                            </a>
                        </div>
                    @endcan

                    @if ($groups->isEmpty())
                        <p>No KPOP groups found.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($groups as $group)
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                                    @if ($group->photo)
                                        <img src="{{ asset('storage/' . $group->photo) }}" alt="{{ $group->name }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 flex items-center justify-center bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400">
                                            No Image
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-gray-100">{{ $group->name }}</h3>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                                            Company: {{ $group->company ?? 'N/A' }}
                                        </p>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-4">
                                            Formed: {{ $group->formation_date ? $group->formation_date->format('M d, Y') : 'N/A' }}
                                        </p>
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('groups.show', $group) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View</a>
                                            @can('update', $group)
                                                <a href="{{ route('groups.edit', $group) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit</a>
                                            @endcan
                                            @can('delete', $group)
                                                <form action="{{ route('groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $groups->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>