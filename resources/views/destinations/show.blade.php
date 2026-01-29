<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Destination Details') }}
            </h2>
            <a href="{{ route('destinations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Destinations
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Destination Image -->
                    @if($destination->image)
                        <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}" class="w-full h-64 object-cover rounded-lg mb-6">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg mb-6">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif

                    <!-- Destination Details -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $destination->name }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Location</h3>
                            <p class="text-gray-600">📍 {{ $destination->location }}</p>
                        </div>

                        @if($destination->price)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Price</h3>
                            <p class="text-2xl font-bold text-blue-600">₱{{ number_format($destination->price, 2) }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $destination->description }}</p>
                    </div>

                    <!-- Coordinates -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Coordinates</h3>
                        <p class="text-gray-600">Latitude: {{ $destination->latitude }}</p>
                        <p class="text-gray-600">Longitude: {{ $destination->longitude }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg flex items-center gap-2">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>

                        @auth
                            <a href="{{ route('destinations.edit', $destination) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg">
                                Edit Destination
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
