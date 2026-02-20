@php
    use App\Models\Booking;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking | Travel Management</title>
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
        
        .sidebar-item.active {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
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
                                    <i class="fas fa-calendar-check mr-3 text-purple-600 dark:text-purple-400"></i>
                                    Edit Booking
                                    <span class="ml-3 text-xs bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 font-bold px-3 py-1 rounded-full">ADMIN</span>
                                </h1>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-4xl mx-auto">
                    
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Bookings
                        </a>
                    </div>

                    <!-- Error Messages -->
                    @if($errors->any())
                    <div class="mb-6">
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

                    <!-- Booking Details Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                <i class="fas fa-edit mr-3 text-purple-600"></i>
                                Booking Details
                            </h2>

                            <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                                @csrf
                                @method('PUT')

                                <!-- User Info (Read-only) -->
                                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                    <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase mb-3">Customer Information</h3>
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg mr-4">
                                            {{ substr($booking->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->user->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $booking->user->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Destination -->
                                    <div>
                                        <label for="destination_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-map-marker-alt mr-2 text-purple-500"></i>Destination
                                        </label>
                                        <select name="destination_id" id="destination_id" 
                                                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                            @foreach($destinations as $destination)
                                                <option value="{{ $destination->id }}" {{ $booking->destination_id == $destination->id ? 'selected' : '' }}>
                                                    {{ $destination->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Booking Date -->
                                    <div>
                                        <label for="booking_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-calendar mr-2 text-purple-500"></i>Booking Date
                                        </label>
                                        <input type="date" name="booking_date" id="booking_date" value="{{ $booking->booking_date->format('Y-m-d') }}"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                    </div>

                                    <!-- Number of Guests -->
                                    <div>
                                        <label for="number_of_guests" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-users mr-2 text-purple-500"></i>Number of Guests
                                        </label>
                                        <input type="number" name="number_of_guests" id="number_of_guests" value="{{ $booking->number_of_guests }}" min="1" max="20"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                    </div>

                                    <!-- Total Amount -->
                                    <div>
                                        <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-dollar-sign mr-2 text-purple-500"></i>Total Amount (₱)
                                        </label>
                                        <input type="number" name="total_amount" id="total_amount" value="{{ $booking->total_amount }}" min="0" step="0.01"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-flag mr-2 text-purple-500"></i>Status
                                        </label>
                                        <select name="status" id="status" 
                                                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Special Requests -->
                                <div class="mt-6">
                                    <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-comment mr-2 text-purple-500"></i>Special Requests
                                    </label>
                                    <textarea name="special_requests" id="special_requests" rows="4"
                                              class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                              placeholder="Enter any special requests...">{{ $booking->special_requests }}</textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-8 flex justify-end">
                                    <a href="{{ route('admin.bookings.index') }}" class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors mr-4">
                                        Cancel
                                    </a>
                                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center">
                                        <i class="fas fa-save mr-2"></i>
                                        Update Booking
                                    </button>
                                </div>
                            </form>
                        </div>
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
