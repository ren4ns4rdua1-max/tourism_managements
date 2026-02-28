<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hotel->name }} | Travel Management</title>
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
                                    <i class="fas fa-hotel mr-3 text-amber-600 dark:text-amber-400"></i>
                                    {{ $hotel->name }}
                                    @for($i = 0; $i < $hotel->star_rating; $i++)
                                        <i class="fas fa-star text-amber-400 ml-1"></i>
                                    @endfor
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-map-marker-alt text-xs mr-2"></i>
                                    {{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->country }}
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
                            <a href="{{ route('hotel.index') }}"
                                class="px-4 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors font-semibold flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Back to Hotels
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto">
                    
                    <!-- Hotel Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row gap-6">
                                <!-- Hotel Image/Icon -->
                                <div class="w-full lg:w-64 h-48 bg-gradient-to-br from-violet-100 to-purple-50 dark:from-violet-900/30 dark:to-purple-800/30 rounded-2xl flex items-center justify-center">
                                    <div class="w-24 h-24 rounded-2xl bg-white/80 dark:bg-gray-800/80 flex items-center justify-center shadow-lg">
                                        <i class="fas fa-hotel text-5xl text-violet-600 dark:text-violet-400"></i>
                                    </div>
                                </div>
                                
                                <!-- Hotel Details -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="px-3 py-1.5 
                                                    @if($hotel->status == 'active') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                                    @elseif($hotel->status == 'inactive') bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                                    @else bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 @endif
                                                    text-xs font-bold rounded-full">
                                                    <i class="fas 
                                                        @if($hotel->status == 'active') fa-check-circle
                                                        @elseif($hotel->status == 'inactive') fa-pause-circle
                                                        @else fa-tools @endif mr-1"></i>
                                                    {{ ucwords(str_replace('_', ' ', $hotel->status)) }}
                                                </span>
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $hotel->description }}</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('hotel.edit', $hotel) }}" class="p-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('hotel.destroy', $hotel) }}" method="POST" onsubmit="return confirm('Delete this hotel?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Contact Info -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                                        @if($hotel->phone)
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3">
                                                <i class="fas fa-phone-alt text-blue-600 dark:text-blue-400"></i>
                                            </div>
                                            {{ $hotel->phone }}
                                        </div>
                                        @endif
                                        @if($hotel->email)
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                                <i class="fas fa-envelope text-green-600 dark:text-green-400"></i>
                                            </div>
                                            {{ $hotel->email }}
                                        </div>
                                        @endif
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mr-3">
                                                <i class="fas fa-door-open text-purple-600 dark:text-purple-400"></i>
                                            </div>
                                            {{ $hotel->rooms->count() }} Rooms
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mr-3">
                                                <i class="fas fa-bed text-emerald-600 dark:text-emerald-400"></i>
                                            </div>
                                            {{ $hotel->rooms->where('status', 'available')->count() }} Available
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rooms Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                                    <i class="fas fa-bed text-violet-600 dark:text-violet-400 mr-3"></i>
                                    Hotel Rooms
                                </h3>
                                <a href="{{ route('hotel.rooms.create', $hotel) }}" 
                                   class="bg-violet-500 hover:bg-violet-600 text-white font-semibold py-2 px-4 rounded-xl transition-colors flex items-center gap-2">
                                    <i class="fas fa-plus"></i> Add Room
                                </a>
                            </div>
                        </div>

                        <div class="p-6">
                            @if($hotel->rooms->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($hotel->rooms as $room)
                                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white flex items-center">
                                                <i class="fas fa-door-open text-violet-500 mr-2"></i>
                                                Room {{ $room->room_number }}
                                            </h4>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $room->room_type }}</span>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-bold rounded-full 
                                            @if($room->status == 'available') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                            @else bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 @endif">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex items-center">
                                            <i class="fas fa-users w-6 text-gray-400"></i>
                                            <span>Capacity: {{ $room->capacity }} guests</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-peso-sign w-6 text-gray-400"></i>
                                            <span class="font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($room->price_per_night, 2) }}/night</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            @if($room->is_ac)
                                                <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs">
                                                    <i class="fas fa-snowflake mr-1"></i>AC
                                                </span>
                                            @endif
                                            @if($room->has_wifi)
                                                <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded text-xs">
                                                    <i class="fas fa-wifi mr-1"></i>WiFi
                                                </span>
                                            @endif
                                            @if($room->has_breakfast)
                                                <span class="px-2 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded text-xs">
                                                    <i class="fas fa-mug-hot mr-1"></i>Breakfast
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-2 mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <a href="{{ route('hotel.rooms.edit', [$hotel, $room]) }}" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg text-sm font-medium text-center transition-colors">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('hotel.rooms.destroy', [$hotel, $room]) }}" method="POST" onsubmit="return confirm('Delete this room?')" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm font-medium transition-colors">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                    <i class="fas fa-bed text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">No Rooms Yet</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">Add rooms to this hotel for guests to book.</p>
                                <a href="{{ route('hotel.rooms.create', $hotel) }}" class="inline-flex items-center gap-2 text-violet-600 hover:text-violet-800 font-semibold">
                                    <i class="fas fa-plus-circle"></i> Add First Room
                                </a>
                            </div>
                            @endif
                        </div>
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
    </script>
</body>
</html>
