@php
    use App\Models\Booking;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings | Tourism Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
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
                                    <i class="fas fa-calendar-alt mr-3 text-blue-600 dark:text-blue-400"></i>
                                    My Bookings
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">View and manage your bookings</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            
                            <!-- Back to Dashboard -->
                            <a href="{{ route('dashboard') }}"
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3">
                                <i class="fas fa-home text-lg"></i>
                                Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-6xl mx-auto">
                    
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-l-4 border-green-500 rounded-xl p-5 shadow-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800/50 flex items-center justify-center mr-4">
                                <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-green-800 dark:text-green-300 text-lg">Success!</h3>
                                <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Bookings List -->
                    @if($bookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-shadow">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <!-- Booking Info -->
                                    <div class="flex items-start gap-4">
                                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shrink-0">
                                            <i class="fas fa-hotel text-2xl"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ $booking->booking_id }}</span>
                                                @switch($booking->status)
                                                    @case('pending')
                                                        <span class="px-2 py-0.5 bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-400 text-xs font-bold rounded-full">
                                                            <i class="fas fa-clock mr-1"></i> Pending
                                                        </span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="px-2 py-0.5 bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 text-xs font-bold rounded-full">
                                                            <i class="fas fa-check mr-1"></i> Confirmed
                                                        </span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="px-2 py-0.5 bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 text-xs font-bold rounded-full">
                                                            <i class="fas fa-times mr-1"></i> Cancelled
                                                        </span>
                                                        @break
                                                    @case('completed')
                                                        <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 text-xs font-bold rounded-full">
                                                            <i class="fas fa-check-double mr-1"></i> Completed
                                                        </span>
                                                        @break
                                                @endswitch
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $booking->destination ? $booking->destination->name : 'Destination' }}</h3>
                                            <div class="flex items-center gap-4 mt-1 text-sm text-gray-600 dark:text-gray-300">
                                                <span><i class="fas fa-user mr-1"></i> {{ $booking->guest_name }}</span>
                                                <span><i class="fas fa-users mr-1"></i> {{ $booking->number_of_guests }} guests</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date & Price -->
                                    <div class="flex items-center gap-6">
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Check-in</p>
                                            <p class="font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</p>
                                        </div>
                                        <i class="fas fa-arrow-right text-gray-400"></i>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Check-out</p>
                                            <p class="font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</p>
                                        </div>
                                        <div class="text-center ml-4">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Total</p>
                                            <p class="font-bold text-emerald-600 dark:text-emerald-400 text-lg">₱{{ number_format($booking->total_price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>

                                @if($booking->special_requests)
                                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-comment mr-2 text-blue-500"></i>
                                        {{ $booking->special_requests }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-lg border border-gray-100 dark:border-gray-700">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-100 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-800/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-calendar-plus text-blue-500 dark:text-blue-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Bookings Yet</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-8">Start exploring destinations and make your first booking!</p>
                            <a href="{{ route('user.destinations.index') }}"
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-3">
                                <i class="fas fa-compass text-lg"></i>
                                Explore Destinations
                            </a>
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
