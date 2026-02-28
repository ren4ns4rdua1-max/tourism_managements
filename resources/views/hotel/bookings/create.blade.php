<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Reservation | Travel Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        
        @include('layouts.sidebar-admin')

        <!-- Mobile Menu Button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="p-2 rounded-lg bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center pl-12 lg:pl-0">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <i class="fas fa-calendar-plus mr-3 text-violet-600 dark:text-violet-400"></i>
                                    Create New Reservation
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-bed text-xs mr-2"></i>
                                    Book a hotel room for a guest
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            
                            <!-- Back Button -->
                            <a href="{{ route('hotel.bookings.index') }}"
                                class="px-4 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors font-semibold flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-4xl mx-auto">

                    <!-- Alerts Section -->
                    @if($errors->any())
                    <div class="mb-8">
                        <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-lg animate-fade-in">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800/50 flex items-center justify-center mr-4 mt-1">
                                    <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-red-800 dark:text-red-300 text-lg mb-2">Please correct the following errors:</h3>
                                    <ul class="list-disc list-inside text-red-700 dark:text-red-400 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Form Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        
                        <!-- Form Header -->
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center text-white mr-4 shadow-lg">
                                    <i class="fas fa-calendar-check text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Reservation Details</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Fill in the booking information below</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Body -->
                        <form action="{{ route('hotel.bookings.store') }}" 
                              method="POST" 
                              class="p-6 space-y-6">
                            @csrf

                            <!-- Hotel Selection -->
                            <div>
                                <label for="hotel_id" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Select Hotel <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-hotel text-gray-400"></i>
                                    </div>
                                    <select name="hotel_id" 
                                            id="hotel_id" 
                                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all appearance-none"
                                            required>
                                        <option value="">-- Select Hotel --</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                                {{ $hotel->name }} - {{ $hotel->city }} ({{ $hotel->rooms->where('status', 'available')->count() }} rooms available)
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('hotel_id')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Guest Information Section -->
                            <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">
                                <h4 class="text-md font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-user text-violet-500 mr-2"></i>
                                    Guest Information
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="guest_name" class="block text-gray-700 dark:text-gray-200 font-medium text-sm mb-1">
                                            Guest Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               name="guest_name" 
                                               id="guest_name" 
                                               value="{{ old('guest_name') }}"
                                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                                               placeholder="e.g., John Doe"
                                               required>
                                        @error('guest_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="guest_email" class="block text-gray-700 dark:text-gray-200 font-medium text-sm mb-1">
                                            Guest Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" 
                                               name="guest_email" 
                                               id="guest_email" 
                                               value="{{ old('guest_email') }}"
                                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                                               placeholder="e.g., john@example.com"
                                               required>
                                        @error('guest_email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="guest_phone" class="block text-gray-700 dark:text-gray-200 font-medium text-sm mb-1">
                                            Phone <span class="text-gray-400 text-xs">(Optional)</span>
                                        </label>
                                        <input type="text" 
                                               name="guest_phone" 
                                               id="guest_phone" 
                                               value="{{ old('guest_phone') }}"
                                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                                               placeholder="e.g., +63 912 345 6789">
                                        @error('guest_phone')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="number_of_guests" class="block text-gray-700 dark:text-gray-200 font-medium text-sm mb-1">
                                            Number of Guests <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" 
                                               name="number_of_guests" 
                                               id="number_of_guests" 
                                               value="{{ old('number_of_guests', 1) }}"
                                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                                               min="1" max="10"
                                               required>
                                        @error('number_of_guests')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Dates Section -->
                            <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">
                                <h4 class="text-md font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-calendar text-violet-500 mr-2"></i>
                                    Booking Dates
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="check_in_date" class="block text-gray-700 dark:text-gray-200 font-medium text-sm mb-1">
                                            Check-in Date <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-sign-in-alt text-gray-400"></i>
                                            </div>
                                            <input type="date" 
                                                   name="check_in_date" 
                                                   id="check_in_date" 
                                                   value="{{ $checkIn }}"
                                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                                                   required>
                                        </div>
                                        @error('check_in_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="check_out_date" class="block text-gray-700 dark:text-gray-200 font-medium text-sm mb-1">
                                            Check-out Date <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-sign-out-alt text-gray-400"></i>
                                            </div>
                                            <input type="date" 
                                                   name="check_out_date" 
                                                   id="check_out_date" 
                                                   value="{{ $checkOut }}"
                                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                                                   required>
                                        </div>
                                        @error('check_out_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Room Selection -->
                            <div>
                                <label for="room_id" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Select Room <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-bed text-gray-400"></i>
                                    </div>
                                    <select name="room_id" 
                                            id="room_id" 
                                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all appearance-none"
                                            required>
                                        <option value="">-- Select a hotel first --</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Room price will be calculated based on number of nights.
                                </p>
                                @error('room_id')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Special Requests -->
                            <div>
                                <label for="special_requests" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Special Requests <span class="text-gray-400 text-xs">(Optional)</span>
                                </label>
                                <textarea name="special_requests" 
                                          id="special_requests" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all resize-none"
                                          placeholder="Any special requests or requirements...">{{ old('special_requests') }}</textarea>
                                @error('special_requests')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                                    <a href="{{ route('hotel.bookings.index') }}" 
                                       class="px-6 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold rounded-xl transition-colors text-center border-2 border-gray-200 dark:border-gray-600">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel
                                    </a>
                                    <button type="submit"
                                            class="px-8 py-3 bg-gradient-to-r from-violet-600 to-purple-500 hover:from-violet-700 hover:to-purple-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-3 group">
                                        <i class="fas fa-calendar-check text-lg"></i>
                                        Create Reservation
                                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }

        // Initialize dark mode
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }

        // Hotel selection - fetch available rooms
        document.getElementById('hotel_id').addEventListener('change', function() {
            const hotelId = this.value;
            const roomSelect = document.getElementById('room_id');
            
            if (!hotelId) {
                roomSelect.innerHTML = '<option value="">-- Select a hotel first --</option>';
                return;
            }

            const checkIn = document.getElementById('check_in_date').value;
            const checkOut = document.getElementById('check_out_date').value;

            // Fetch available rooms for the selected hotel
            fetch(`/hotel/${hotelId}/rooms/available?check_in=${checkIn}&check_out=${checkOut}`)
                .then(response => response.json())
                .then(data => {
                    roomSelect.innerHTML = '<option value="">-- Select Room --</option>';
                    if (data.rooms && data.rooms.length > 0) {
                        data.rooms.forEach(room => {
                            const option = document.createElement('option');
                            option.value = room.id;
                            option.textContent = `${room.room_number} - ${room.room_type} (₱${room.price_per_night}/night) - Capacity: ${room.capacity} guests`;
                            option.dataset.price = room.price_per_night;
                            roomSelect.appendChild(option);
                        });
                    } else {
                        roomSelect.innerHTML = '<option value="">No rooms available</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching rooms:', error);
                    roomSelect.innerHTML = '<option value="">Error loading rooms</option>';
                });
        });

        // Update rooms when dates change
        document.getElementById('check_in_date').addEventListener('change', function() {
            document.getElementById('hotel_id').dispatchEvent(new Event('change'));
        });
        document.getElementById('check_out_date').addEventListener('change', function() {
            document.getElementById('hotel_id').dispatchEvent(new Event('change'));
        });
    </script>
</body>
</html>
