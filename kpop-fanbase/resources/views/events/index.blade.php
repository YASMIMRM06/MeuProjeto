<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('KPOP Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('create', App\Models\Event::class)
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Create New Event
                            </a>
                        </div>
                    @endcan

                    @if ($events->isEmpty())
                        <p>No KPOP events found.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($events as $event)
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden p-4">
                                    <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-gray-100">{{ $event->name }}</h3>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                                        <i class="fa-solid fa-calendar"></i> Date: {{ $event->event_date->format('M d, Y H:i A') }}
                                    </p>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                                        <i class="fa-solid fa-location-dot"></i> Location: {{ $event->location }}
                                    </p>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm mb-4">
                                        Status: <span class="font-semibold {{ $event->status === 'scheduled' ? 'text-green-500' : ($event->status === 'canceled' ? 'text-red-500' : 'text-blue-500') }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </p>
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View</a>
                                        @can('update', $event)
                                            <a href="{{ route('events.edit', $event) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit</a>
                                        @endcan
                                        @can('delete', $event)
                                            <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
