<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room | Travel Management</title>
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
                                    <i class="fas fa-door-open mr-3 text-violet-600 dark:text-violet-400"></i>
                                    Add New Room
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-hotel text-xs mr-2"></i>
                                    {{ $hotel->name }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            
                            <a href="{{ route('hotel.show', $hotel) }}"
                                class="px-4 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors font-semibold flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Back to Hotel
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-4xl mx-auto">

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
                        
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center text-white mr-4 shadow-lg">
                                    <i class="fas fa-bed text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Room Information</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Add a new room to this hotel</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('hotel.rooms.store', $hotel) }}" method="POST" class="p-6 space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="room_number" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Room Number <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-door-open text-gray-400"></i>
                                        </div>
                                        <input type="text" name="room_number" id="room_number" value="{{ old('room_number') }}"
                                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                                            placeholder="e.g., 101" required>
                                    </div>
                                    @error('room_number')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="room_type" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Room Type <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-tags text-gray-400"></i>
                                        </div>
                                        <select name="room_type" id="room_type" class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all appearance-none" required>
                                            <option value="">Select Type</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Deluxe">Deluxe</option>
                                            <option value="Suite">Suite</option>
                                            <option value="Family">Family</option>
                                            <option value="President">Presidential</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('room_type')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="capacity" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Capacity (Guests) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-users text-gray-400"></i>
                                        </div>
                                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 2) }}"
                                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                                            min="1" max="10" required>
                                    </div>
                                    @error('capacity')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="price_per_night" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Price per Night (₱) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-peso-sign text-gray-400"></i>
                                        </div>
                                        <input type="number" name="price_per_night" id="price_per_night" value="{{ old('price_per_night') }}"
                                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                                            step="0.01" placeholder="0.00" required>
                                    </div>
                                    @error('price_per_night')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Description <span class="text-gray-400 text-xs">(Optional)</span>
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all resize-none"
                                    placeholder="Room description and amenities...">{{ old('description') }}</textarea>
                            </div>

                            <!-- Amenities -->
                            <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">
                                <h4 class="text-md font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-concierge-bell text-violet-500 mr-2"></i>
                                    Amenities
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_ac" value="1" {{ old('is_ac') ? 'checked' : '' }}
                                            class="w-5 h-5 text-violet-600 border-gray-300 rounded focus:ring-violet-500 dark:border-gray-600 dark:bg-gray-700">
                                        <span class="ml-3 text-gray-700 dark:text-gray-200 font-medium">
                                            <i class="fas fa-snowflake mr-1 text-blue-500"></i> Air Conditioning
                                        </span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="has_wifi" value="1" {{ old('has_wifi') ? 'checked' : '' }}
                                            class="w-5 h-5 text-violet-600 border-gray-300 rounded focus:ring-violet-500 dark:border-gray-600 dark:bg-gray-700">
                                        <span class="ml-3 text-gray-700 dark:text-gray-200 font-medium">
                                            <i class="fas fa-wifi mr-1 text-green-500"></i> WiFi
                                        </span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="has_breakfast" value="1" {{ old('has_breakfast') ? 'checked' : '' }}
                                            class="w-5 h-5 text-violet-600 border-gray-300 rounded focus:ring-violet-500 dark:border-gray-600 dark:bg-gray-700">
                                        <span class="ml-3 text-gray-700 dark:text-gray-200 font-medium">
                                            <i class="fas fa-mug-hot mr-1 text-amber-500"></i> Breakfast
                                        </span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="has_parking" value="1" {{ old('has_parking') ? 'checked' : '' }}
                                            class="w-5 h-5 text-violet-600 border-gray-300 rounded focus:ring-violet-500 dark:border-gray-600 dark:bg-gray-700">
                                        <span class="ml-3 text-gray-700 dark:text-gray-200 font-medium">
                                            <i class="fas fa-parking mr-1 text-gray-500"></i> Parking
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label for="status" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-toggle-on text-gray-400"></i>
                                    </div>
                                    <select name="status" id="status" class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all appearance-none" required>
                                        <option value="available" selected>Available</option>
                                        <option value="occupied">Occupied</option>
                                        <option value="maintenance">Under Maintenance</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                                    <a href="{{ route('hotel.show', $hotel) }}" 
                                       class="px-6 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold rounded-xl transition-colors text-center border-2 border-gray-200 dark:border-gray-600">
                                        <i class="fas fa-times mr-2"></i> Cancel
                                    </a>
                                    <button type="submit"
                                        class="px-8 py-3 bg-gradient-to-r from-violet-600 to-purple-500 hover:from-violet-700 hover:to-purple-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-3 group">
                                        <i class="fas fa-plus-circle text-lg"></i>
                                        Add Room
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
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
