@php
    use App\Models\Destination;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Destination | Tourism Portal</title>
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
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        
        @include('layouts.sidebar-user')

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
                                    <i class="fas fa-calendar-check mr-3 text-primary-600 dark:text-primary-400"></i>
                                    Book Destination
                                </h1>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            
                            <!-- Back -->
                            <a href="{{ route('user.destinations.index') }}"
                                class="bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-700 hover:to-gray-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3">
                                <i class="fas fa-arrow-left text-lg"></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-4xl mx-auto">
                    
                    <!-- Destination Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden mb-8 border border-gray-100 dark:border-gray-700">
                        <div class="md:flex">
                            <!-- Image -->
                            <div class="md:w-1/3 h-64 md:h-auto">
                                @if($destination->image)
                                    <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                        <i class="fas fa-map-marked-alt text-6xl text-white/50"></i>
                                    </div>
                                @endif
                            </div>
                            <!-- Info -->
                            <div class="p-6 md:w-2/3">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i> Available
                                    </span>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $destination->name }}</h2>
                                <div class="flex items-center text-gray-600 dark:text-gray-300 mb-3">
                                    <i class="fas fa-location-dot text-red-500 mr-2"></i>
                                    {{ $destination->location }}
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ Str::limit($destination->description, 150) }}</p>
                                @if($destination->price)
                                <div class="bg-emerald-50 dark:bg-emerald-500/10 rounded-xl p-4 inline-block">
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Starting at</p>
                                    <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">₱{{ number_format($destination->price, 2) }} <span class="text-sm font-normal">/ night</span></p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-clipboard-list mr-3 text-blue-500"></i>
                            Booking Details
                        </h3>

                        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <input type="hidden" name="destination_id" value="{{ $destination->id }}">

                            <!-- Guest Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="guest_name" required 
                                        value="{{ Auth::user()->name }}"
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Enter your full name">
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="guest_email" required 
                                        value="{{ Auth::user()->email }}"
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Enter your email">
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="guest_phone" required 
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Enter your phone number">
                            </div>

                            <!-- Date Selection -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Check-in Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="check_in_date" required 
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Check-out Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="check_out_date" required 
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Number of Guests <span class="text-red-500">*</span>
                                </label>
                                <select name="number_of_guests" required 
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select number of guests</option>
                                    @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Special Requests <span class="text-gray-400 text-xs">(Optional)</span>
                                </label>
                                <textarea name="special_requests" rows="4" 
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                    placeholder="Any special requests or requirements..."></textarea>
                            </div>

                            <!-- Price Calculation Info -->
                            <div class="bg-blue-50 dark:bg-blue-500/10 rounded-xl p-4 border border-blue-100 dark:border-blue-500/20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Total Price</p>
                                        <p class="text-xs text-blue-500 dark:text-blue-300">Calculated based on nights × destination price</p>
                                    </div>
                                    @if($destination->price)
                                    <div class="text-right">
                                        <p class="text-2xl font-black text-blue-600 dark:text-blue-400">₱{{ number_format($destination->price, 2) }}</p>
                                        <p class="text-xs text-blue-500 dark:text-blue-300">per night</p>
                                    </div>
                                    @else
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400">Contact for price</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-3">
                                    <i class="fas fa-check-circle text-lg"></i>
                                    Confirm Booking
                                </button>
                                <a href="{{ route('user.destinations.index') }}"
                                    class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium">
                                    Cancel
                                </a>
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
    </script>
</body>
</html>
