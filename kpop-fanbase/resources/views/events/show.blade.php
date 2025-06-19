<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
{{ $event->name }}
</h2>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <p class="text-lg mb-2"><strong>Description:</strong> {{ $event->description ?? 'N/A' }}</p>
                        <p class="text-lg mb-2"><strong>Date & Time:</strong> {{ $event->event_date->format('M d, Y H:i A') }}</p>
                        <p class="text-lg mb-2"><strong>Location:</strong> {{ $event->location }}</p>
                        <p class="text-lg mb-2"><strong>Capacity:</strong> {{ $event->capacity ?? 'Unlimited' }}</p>
                        <p class="text-lg mb-2"><strong>Status:</strong> <span class="font-semibold {{ $event->status === 'scheduled' ? 'text-green-500' : ($event->status === 'canceled' ? 'text-red-500' : 'text-blue-500') }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </p>
                        <p class="text-lg mb-2"><strong>Created By:</strong> {{ $event->creator->name }}</p>
                    </div>

                    <hr class="my-6 border-gray-300 dark:border-gray-600">

                    <h3 class="text-xl font-semibold mb-3">Participation</h3>
                    @if (Auth::check())
                        @php
                            $isParticipating = Auth::user()->eventsParticipating->contains($event->id);
                        @endphp

                        @if ($isParticipating)
                            <form action="{{ route('events.cancel', $event) }}" method="POST">
                                @csrf
                                <x-primary-button class="bg-red-500 hover:bg-red-700">Cancel Participation</x-primary-button>
                            </form>
                        @else
                            <form action="{{ route('events.participate', $event) }}" method="POST">
                                @csrf
                                <x-primary-button>Participate</x-primary-button>
                            </form>
                        @endif
                    @else
                        <p class="text-gray-600 dark:text-gray-400">Log in to participate in this event.</p>
                    @endif

                    <h4 class="text-xl font-semibold mt-6 mb-3">Participants ({{ $event->participants->count() }})</h4>
                    @if ($event->participants->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">No participants yet.</p>
                    @else
                        <ul class="list-disc list-inside">
                            @foreach ($event->participants as $participant)
                                <li><a href="{{ route('profile.show', $participant) }}" class="text-indigo-600 hover:underline">{{ $participant->name }}</a> ({{ ucfirst($participant->pivot->status) }})</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-6 flex justify-end space-x-2">
                        @can('update', $event)
                            <a href="{{ route('events.edit', $event) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit Event</a>
                        @endcan
                        @can('delete', $event)
                            <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete Event</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
