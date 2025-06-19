<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $group->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6 flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
                        @if ($group->photo)
                            <img src="{{ asset('storage/' . $group->photo) }}" alt="{{ $group->name }}" class="w-48 h-48 object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-48 h-48 flex items-center justify-center bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400 rounded-lg shadow-md text-center">
                                No Group Image
                            </div>
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold mb-2">{{ $group->name }}</h3>
                            <p class="text-lg mb-2"><strong>Company:</strong> {{ $group->company ?? 'N/A' }}</p>
                            <p class="text-lg mb-2"><strong>Formation Date:</strong> {{ $group->formation_date ? $group->formation_date->format('M d, Y') : 'N/A' }}</p>
                            <p class="text-lg mb-4"><strong>Description:</strong> {{ $group->description ?? 'No description available.' }}</p>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300 dark:border-gray-600">

                    <h3 class="text-2xl font-semibold mb-4">Music by {{ $group->name }}</h3>
                    @if ($group->music->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">No music found for this group yet.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($group->music as $music)
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                                    <h4 class="font-semibold text-lg mb-1">{{ $music->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Release Date: {{ $music->release_date?->format('M d, Y') ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Rating: {{ number_format($music->average_rating, 1) }} / 5</p>
                                    <a href="{{ route('musics.show', $music) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm mt-2 inline-block">View Details</a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-6 flex justify-end space-x-2">
                        @can('update', $group)
                            <a href="{{ route('groups.edit', $group) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit Group</a>
                        @endcan
                        @can('delete', $group)
                            <form action="{{ route('groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete Group</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>