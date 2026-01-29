<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Destinations') }}
            </h2>
            <a href="{{ route('destinations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Destination
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Map Display -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Destinations Map</h3>
                    <div id="map" style="height: 500px; width: 100%;"></div>
                </div>
            </div>

            <!-- Destinations Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($destinations as $destination)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if($destination->image)
                            <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $destination->name }}</h3>
                            <p class="text-gray-600 mb-2">📍 {{ $destination->location }}</p>
                            <p class="text-gray-700 mb-4">{{ Str::limit($destination->description, 100) }}</p>
                            
                            @if($destination->price)
                                <p class="text-lg font-bold text-blue-600 mb-4">₱{{ number_format($destination->price, 2) }}</p>
                            @endif

                            <div class="flex gap-2">
                                <a href="{{ route('destinations.edit', $destination) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('destinations.destroy', $destination) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8 text-gray-500">
                        No destinations found. <a href="{{ route('destinations.create') }}" class="text-blue-500">Add your first destination</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize map centered on Philippines (Cebu)
        const map = L.map('map').setView([10.3157, 123.8854], 6);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Add markers for each destination
        const destinations = @json($destinations);
        
        destinations.forEach(destination => {
            const marker = L.marker([destination.latitude, destination.longitude])
                .addTo(map);
            
            let popupContent = `
                <div style="min-width: 200px;">
                    <h3 style="font-weight: bold; margin-bottom: 8px;">${destination.name}</h3>
                    <p style="margin-bottom: 4px;">${destination.location}</p>
                    <p style="margin-bottom: 8px;">${destination.description.substring(0, 100)}...</p>
                    ${destination.price ? `<p style="font-weight: bold; color: #2563eb;">₱${parseFloat(destination.price).toFixed(2)}</p>` : ''}
                </div>
            `;
            
            marker.bindPopup(popupContent);
        });

        // Fit map to show all markers if there are destinations
        if (destinations.length > 0) {
            const group = new L.featureGroup(
                destinations.map(d => L.marker([d.latitude, d.longitude]))
            );
            map.fitBounds(group.getBounds().pad(0.1));
        }
    </script>
    @endpush
</x-app-layout>