<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Availability | Travel Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { primary: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' } },
                    animation: { 'fade-in': 'fadeIn 0.3s ease-in-out' },
                    keyframes: { fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } } }
                }
            }
        }
    </script>
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        @include('layouts.sidebar-admin')
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center pl-12 lg:pl-0">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <i class="fas fa-calendar-check mr-3 text-emerald-600 dark:text-emerald-400"></i>
                                    Check Room Availability
                                </h1>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button onclick="toggleDarkMode()" class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            <a href="{{ route('hotel.bookings.index') }}" class="px-4 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors font-semibold flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i> Back to Bookings
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto">
                    <!-- Search Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white mr-4 shadow-lg">
                                    <i class="fas fa-search text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Search Availability</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Find available rooms for your dates</p>
                                </div>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('hotel.bookings.availability') }}" class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label for="hotel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hotel <span class="text-red-500">*</span></label>
                                    <select name="hotel_id" id="hotel_id" class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-emerald-500" required>
                                        <option value="">Select Hotel</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }} - {{ $hotel->city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-in <span class="text-red-500">*</span></label>
                                    <input type="date" name="check_in_date" id="check_in_date" value="{{ old('check_in_date', $checkIn ?? '') }}" class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label for="check_out_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-out <span class="text-red-500">*</span></label>
                                    <input type="date" name="check_out_date" id="check_out_date" value="{{ old('check_out_date', $checkOut ?? '') }}" class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label for="guests" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Guests</label>
                                    <input type="number" name="guests" id="guests" value="{{ old('guests', 1) }}" min="1" max="10" class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2.5 px-6 rounded-xl transition-colors flex items-center gap-2">
                                    <i class="fas fa-search"></i> Check Availability
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Results -->
                    @if(isset($availableRooms))
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-bed text-emerald-600 dark:text-emerald-400 mr-3"></i>
                                Available Rooms at {{ $hotel->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                {{ \Carbon\Carbon::parse($checkIn)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($checkOut)->format('M d, Y') }}
                                <span class="ml-2 px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full text-xs">
                                    {{ \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)) }} nights
                                </span>
                            </p>
                        </div>
                        <div class="p-6">
                            @if(count($availableRooms) > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($availableRooms as $room)
                                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow">
                                            <div class="flex justify-between items-start mb-3">
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                                                        <i class="fas fa-door-open text-violet-500 mr-2"></i>
                                                        Room {{ $room->room_number }}
                                                    </h4>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($room->room_type) }}</span>
                                                </div>
                                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                                    <i class="fas fa-check mr-1"></i> Available
                                                </span>
                                            </div>
                                            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300 mb-4">
                                                <div class="flex items-center"><i class="fas fa-users w-6 text-gray-400"></i> Capacity: {{ $room->capacity }} guests</div>
                                                <div class="flex items-center"><i class="fas fa-peso-sign w-6 text-gray-400"></i> <span class="font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($room->price_per_night, 2) }}/night</span></div>
                                            </div>
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @if($room->is_ac)<span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs"><i class="fas fa-snowflake mr-1"></i>AC</span>@endif
                                                @if($room->has_wifi)<span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded text-xs"><i class="fas fa-wifi mr-1"></i>WiFi</span>@endif
                                                @if($room->has_breakfast)<span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded text-xs"><i class="fas fa-mug-hot mr-1"></i>Breakfast</span>@endif
                                            </div>
                                            @php
                                                $nights = \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut));
                                                $total = $room->price_per_night * $nights;
                                            @endphp
                                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                                <p class="text-xl font-bold text-gray-900 dark:text-white">
                                                    Total: ₱{{ number_format($total, 2) }}
                                                    <span class="text-sm font-normal text-gray-500">({{ $nights }} nights)</span>
                                                </p>
                                                <a href="{{ route('hotel.bookings.create') }}?hotel_id={{ $hotel->id }}&room_id={{ $room->id }}&check_in={{ $checkIn }}&check_out={{ $checkOut }}" 
                                                   class="mt-3 block w-full bg-gradient-to-r from-violet-600 to-purple-500 hover:from-violet-700 hover:to-purple-600 text-white font-semibold py-2.5 px-4 rounded-xl text-center transition-all">
                                                    <i class="fas fa-calendar-check mr-2"></i> Book This Room
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                        <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">No Rooms Available</h3>
                                    <p class="text-gray-500 dark:text-gray-400">No rooms available for the selected dates. Please try different dates or another hotel.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
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
