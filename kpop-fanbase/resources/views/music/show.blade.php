<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $music->title }} by {{ $music->group->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <p class="text-lg mb-2"><strong>Title:</strong> {{ $music->title }}</p>
                        <p class="text-lg mb-2"><strong>Group:</strong> <a href="{{ route('groups.show', $music->group) }}" class="text-indigo-600 hover:underline">{{ $music->group->name }}</a></p>
                        <p class="text-lg mb-2"><strong>Release Date:</strong> {{ $music->release_date?->format('M d, Y') ?? 'N/A' }}</p>
                        <p class="text-lg mb-2"><strong>Duration:</strong> {{ $music->duration?->format('H:i:s') ?? 'N/A' }}</p>
                        <p class="text-lg mb-2"><strong>Average Rating:</strong> {{ number_format($music->average_rating, 1) }} / 5</p>

                        @if ($music->youtube_link)
                            <div class="mt-4">
                                <h3 class="text-xl font-semibold mb-2">YouTube Video</h3>
                                <div class="aspect-w-16 aspect-h-9">
                                    <iframe class="w-full h-96" src="https://www.youtube.com/embed/{{ \Str::afterLast($music->youtube_link, '/') }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr class="my-6 border-gray-300 dark:border-gray-600">

                    <h3 class="text-2xl font-semibold mb-4">Ratings & Reviews</h3>

                    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                        <h4 class="text-xl font-semibold mb-3">Submit Your Rating</h4>
                        @if (Auth::user()->ratings->where('music_id', $music->id)->isEmpty())
                            <form action="{{ route('ratings.store', $music) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="rating" :value="__('Your Rating (1-5)')" />
                                    <x-text-input id="rating" type="number" name="rating" min="1" max="5" class="block mt-1 w-full" required />
                                    <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="comment" :value="__('Your Comment')" />
                                    <x-textarea id="comment" name="comment" rows="3" class="block mt-1 w-full"></x-textarea>
                                    <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                                </div>
                                <x-primary-button>
                                    {{ __('Submit Rating') }}
                                </x-primary-button>
                            </form>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">You have already rated this music. You can edit your existing rating below.</p>
                        @endif
                    </div>

                    @if ($music->ratings->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">No ratings yet for this music.</p>
                    @else
                        <div class="space-y-6">
                            @foreach ($music->ratings as $rating)
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="font-semibold text-lg">{{ $rating->user->name }} - {{ $rating->rating }} / 5 Stars</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $rating->created_at->diffForHumans() }}</p>
                                    </div>
                                    @if ($rating->comment)
                                        <p class="text-gray-800 dark:text-gray-200">{{ $rating->comment }}</p>
                                    @endif

                                    @can('update', $rating)
                                        <div x-data="{ editing: false }" class="mt-4">
                                            <button @click="editing = !editing" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                                <span x-show="!editing">Edit Rating</span>
                                                <span x-show="editing">Cancel Edit</span>
                                            </button>
                                            <form x-show="editing" action="{{ route('ratings.update', $rating) }}" method="POST" class="mt-2">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-2">
                                                    <x-input-label for="edit_rating_{{ $rating->id }}" :value="__('New Rating (1-5)')" />
                                                    <x-text-input id="edit_rating_{{ $rating->id }}" type="number" name="rating" min="1" max="5" value="{{ $rating->rating }}" class="block mt-1 w-full" required />
                                                </div>
                                                <div class="mb-2">
                                                    <x-input-label for="edit_comment_{{ $rating->id }}" :value="__('New Comment')" />
                                                    <x-textarea id="edit_comment_{{ $rating->id }}" name="comment" rows="2" class="block mt-1 w-full">{{ $rating->comment }}</x-textarea>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <x-primary-button>Update</x-primary-button>
                                                </div>
                                            </form>
                                        </div>
                                    @endcan
                                    @can('delete', $rating)
                                        <form action="{{ route('ratings.destroy', $rating) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this rating?');" class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm">Delete Rating</button>
                                        </form>
                                    @endcan
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
