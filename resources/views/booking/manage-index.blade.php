@php
    use App\Models\Booking;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings | Tourism Portal</title>
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
        
        @include('layouts.sidebar-manager')

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
                                    <i class="fas fa-calendar-check mr-3 text-green-600 dark:text-green-400"></i>
                                    Manage Bookings
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">View and manage all user bookings</p>
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
                                class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3">
                                <i class="fas fa-home text-lg"></i>
                                Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto">
                    
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

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Total</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $bookings->count() }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <i class="fas fa-calendar text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Pending</p>
                                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $bookings->where('status', 'pending')->count() }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Confirmed</p>
                                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Cancelled</p>
                                    <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                    <i class="fas fa-times-circle text-red-600 dark:text-red-400 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings Table -->
                    @if($bookings->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Booking ID</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Destination</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dates</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Guests</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($bookings as $booking)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-mono text-gray-900 dark:text-white">{{ $booking->booking_id }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs mr-3">
                                                    {{ substr($booking->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->user->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $booking->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->destination ? $booking->destination->name : 'N/A' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $booking->destination ? $booking->destination->location : '' }}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">to {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900 dark:text-white">{{ $booking->number_of_guests }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($booking->total_price, 2) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($booking->status)
                                                @case('pending')
                                                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-400 text-xs font-bold rounded-full">
                                                        <i class="fas fa-clock mr-1"></i> Pending
                                                    </span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 text-xs font-bold rounded-full">
                                                        <i class="fas fa-check mr-1"></i> Confirmed
                                                    </span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="px-3 py-1 bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 text-xs font-bold rounded-full">
                                                        <i class="fas fa-times mr-1"></i> Cancelled
                                                    </span>
                                                    @break
                                                @case('completed')
                                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 text-xs font-bold rounded-full">
                                                        <i class="fas fa-check-double mr-1"></i> Completed
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-500/20 text-gray-700 dark:text-gray-400 text-xs font-bold rounded-full">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($booking->status === 'pending')
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('bookings.manage.confirm', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                        class="p-2 bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-200 dark:hover:bg-green-500/30 transition-colors"
                                                        title="Confirm Booking">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('bookings.manage.cancel', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                                    @csrf
                                                    <button type="submit" 
                                                        class="p-2 bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-500/30 transition-colors"
                                                        title="Cancel Booking">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500">No actions</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-lg border border-gray-100 dark:border-gray-700">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-green-100 to-emerald-50 dark:from-green-900/30 dark:to-emerald-800/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-calendar-check text-green-500 dark:text-green-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Bookings Yet</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-8">User bookings will appear here once they make reservations.</p>
                            <a href="{{ route('dashboard') }}"
                                class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-3">
                                <i class="fas fa-home text-lg"></i>
                                Back to Dashboard
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
