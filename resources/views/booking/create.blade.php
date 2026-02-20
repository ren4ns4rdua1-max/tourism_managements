<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Destination Info -->
                    @if($destination)
                        <div class="mb-6 bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">
                                Booking for: {{ $destination->name }}
                            </h3>
                            <p class="text-blue-700 dark:text-blue-300">
                                <i class="fas fa-map-marker-alt"></i> {{ $destination->location }}
                            </p>
                            @if($destination->price)
                                <p class="text-blue-700 dark:text-blue-300 mt-2">
                                    <strong>Price:</strong> ₱{{ number_format($destination->price, 2) }}
                                </p>
                            @endif
                        </div>
                    @endif

                    <form method="POST" action="{{ route('booking.store') }}">
                        @csrf

                        <!-- Destination Selection -->
                        <div class="mb-6">
                            <x-input-label for="destination_id" :value="__('Destination')" />
                            <select id="destination_id" name="destination_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Select Destination --</option>
                                @foreach($destinations as $dest)
                                    <option value="{{ $dest->id }}" {{ $destination && $destination->id == $dest->id ? 'selected' : '' }}>
                                        {{ $dest->name }} - ₱{{ number_format($dest->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('destination_id')" class="mt-2" />
                        </div>

                        <!-- Booking Date -->
                        <div class="mb-6">
                            <x-input-label for="booking_date" :value="__('Booking Date')" />
                            <x-text-input id="booking_date" class="block mt-1 w-full" type="date" name="booking_date" :value="old('booking_date')" required min="{{ date('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('booking_date')" class="mt-2" />
                        </div>

                        <!-- Number of Guests -->
                        <div class="mb-6">
                            <x-input-label for="number_of_guests" :value="__('Number of Guests')" />
                            <x-text-input id="number_of_guests" class="block mt-1 w-full" type="number" name="number_of_guests" :value="old('number_of_guests', 1)" required min="1" max="20" />
                            <x-input-error :messages="$errors->get('number_of_guests')" class="mt-2" />
                        </div>

                        <!-- Special Requests -->
                        <div class="mb-6">
                            <x-input-label for="special_requests" :value="__('Special Requests (Optional)')" />
                            <textarea id="special_requests" name="special_requests" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 rounded-md shadow-sm">{{ old('special_requests') }}</textarea>
                            <x-input-error :messages="$errors->get('special_requests')" class="mt-2" />
                        </div>

                        <!-- Total Amount (calculated) -->
                        <div class="mb-6">
                            <x-input-label for="total_amount" :value="__('Total Amount')" />
                            <x-text-input id="total_amount" class="block mt-1 w-full" type="number" name="total_amount" :value="old('total_amount')" required min="0" step="0.01" />
                            <x-input-error :messages="$errors->get('total_amount')" class="mt-2" />
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Enter the total amount based on destination price and number of guests.</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Create Booking') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Calculate total amount based on destination price and number of guests
        document.addEventListener('DOMContentLoaded', function() {
            const destinationSelect = document.getElementById('destination_id');
            const guestsInput = document.getElementById('number_of_guests');
            const totalInput = document.getElementById('total_amount');
            
            // Get destination price from the selected option
            function calculateTotal() {
                const selectedOption = destinationSelect.options[destinationSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    // Extract price from the option text (format: "Name - ₱1,234.56")
                    const text = selectedOption.text;
                    const priceMatch = text.match(/₱([\d,]+\.?\d*)/);
                    if (priceMatch) {
                        const price = parseFloat(priceMatch[1].replace(/,/g, ''));
                        const guests = parseInt(guestsInput.value) || 1;
                        totalInput.value = (price * guests).toFixed(2);
                    }
                }
            }
            
            destinationSelect.addEventListener('change', calculateTotal);
            guestsInput.addEventListener('input', calculateTotal);
        });
    </script>
</x-app-layout>
