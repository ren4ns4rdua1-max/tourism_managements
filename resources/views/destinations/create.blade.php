<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($destination) ? __('Edit Destination') : __('Add New Destination') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ isset($destination) ? route('destinations.update', $destination) : route('destinations.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($destination))
                            @method('PUT')
                        @endif

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Destination Name *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $destination->name ?? '') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                            <input type="text" 
                                   name="location" 
                                   id="location" 
                                   value="{{ old('location', $destination->location ?? '') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g., Cebu City, Philippines"
                                   required>
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Coordinates -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude *</label>
                                <input type="number" 
                                       name="latitude" 
                                       id="latitude" 
                                       step="0.00000001"
                                       value="{{ old('latitude', $destination->latitude ?? '') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="10.3157"
                                       required>
                                @error('latitude')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude *</label>
                                <input type="number" 
                                       name="longitude" 
                                       id="longitude" 
                                       step="0.00000001"
                                       value="{{ old('longitude', $destination->longitude ?? '') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="123.8854"
                                       required>
                                @error('longitude')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Map for selecting coordinates -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Click on map to select location
                            </label>
                            <div id="map" style="height: 400px; width: 100%;" class="rounded-lg border border-gray-300"></div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                      required>{{ old('description', $destination->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (₱)</label>
                            <input type="number" 
                                   name="price" 
                                   id="price" 
                                   step="0.01"
                                   value="{{ old('price', $destination->price ?? '') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="0.00">
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   accept="image/*"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @if(isset($destination) && $destination->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $destination->image) }}" alt="Current image" class="h-32 rounded">
                                </div>
                            @endif
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                {{ isset($destination) ? 'Update' : 'Create' }} Destination
                            </button>
                            <a href="{{ route('destinations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Get initial coordinates or default to Cebu
        const initialLat = {{ old('latitude', $destination->latitude ?? 10.3157) }};
        const initialLng = {{ old('longitude', $destination->longitude ?? 123.8854) }};

        // Initialize map
        const map = L.map('map').setView([initialLat, initialLng], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Add marker
        let marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);

        // Update coordinates when marker is dragged
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat.toFixed(8);
            document.getElementById('longitude').value = position.lng.toFixed(8);
        });

        // Add marker on map click
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat.toFixed(8);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(8);
        });

        // Update marker when coordinates are manually entered
        document.getElementById('latitude').addEventListener('change', updateMarker);
        document.getElementById('longitude').addEventListener('change', updateMarker);

        function updateMarker() {
            const lat = parseFloat(document.getElementById('latitude').value);
            const lng = parseFloat(document.getElementById('longitude').value);
            
            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 13);
            }
        }
    </script>
    @endpush
</x-app-layout>