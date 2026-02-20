@php
    use App\Models\Booking;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Management | Travel Management</title>
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
                        'slide-in': 'slideIn 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.15);
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
                                    <i class="fas fa-calendar-check mr-3 text-emerald-600 dark:text-emerald-400"></i>
                                    Booking Management
                                    <span class="ml-3 text-xs bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-bold px-3 py-1 rounded-full">MANAGER</span>
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
                            
                            <!-- Search -->
                            <div class="hidden md:block relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 w-64 text-sm transition-all"
                                       placeholder="Search bookings...">
                            </button>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto">
                    
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="mb-6">
                        <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-l-4 border-green-500 rounded-xl p-5 shadow-lg animate-fade-in">
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
                    </div>
                    @endif

                    <!-- Error Message -->
                    @if(session('error'))
                    <div class="mb-6">
                        <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-lg animate-fade-in">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800/50 flex items-center justify-center mr-4">
                                    <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-red-800 dark:text-red-300 text-lg">Error!</h3>
                                    <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Bookings Header -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">All Bookings</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">View and manage travel bookings</p>
                        </div>
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            <select class="appearance-none bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 pl-4 pr-10 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-primary-500">
                                <option>All Bookings</option>
                                <option>Pending</option>
                                <option>Confirmed</option>
                                <option>Cancelled</option>
                                <option>Completed</option>
                            </select>
                            <button class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-filter text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Bookings Table -->
                    @if($bookings->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-hashtag mr-2"></i>ID
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-user mr-2"></i>User
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-map-marker-alt mr-2"></i>Destination
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-calendar mr-2"></i>Date
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-users mr-2"></i>Guests
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-dollar-sign mr-2"></i>Amount
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-flag mr-2"></i>Status
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-cogs mr-2"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($bookings as $booking)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-gray-900 dark:text-white">#{{ $booking->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white font-bold text-xs mr-3">
                                                    {{ substr($booking->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->user->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $booking->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->destination->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $booking->destination->location }}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-friends text-gray-400 mr-2"></i>
                                                <span class="text-sm text-gray-900 dark:text-white">{{ $booking->number_of_guests }} Guest(s)</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($booking->total_amount, 2) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($booking->status == 'confirmed')
                                                <span class="px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-bold rounded-full">
                                                    <i class="fas fa-check-circle mr-1"></i> Confirmed
                                                </span>
                                            @elseif($booking->status == 'pending')
                                                <span class="px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-xs font-bold rounded-full">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </span>
                                            @elseif($booking->status == 'cancelled')
                                                <span class="px-3 py-1.5 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-bold rounded-full">
                                                    <i class="fas fa-times-circle mr-1"></i> Cancelled
                                                </span>
                                            @elseif($booking->status == 'completed')
                                                <span class="px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-full">
                                                    <i class="fas fa-check-double mr-1"></i> Completed
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                @if($booking->status == 'pending')
                                                    <form action="{{ route('manager.bookings.accept', $booking) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="p-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors"
                                                                title="Accept Booking"
                                                                onclick="return confirm('Are you sure you want to accept this booking?');">
                                                            <i class="fas fa-check text-sm"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('manager.bookings.decline', $booking) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="p-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors"
                                                                title="Decline Booking"
                                                                onclick="return confirm('Are you sure you want to decline this booking?');">
                                                            <i class="fas fa-times text-sm"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('manager.bookings.edit', $booking) }}" 
                                                   class="p-2 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-lg hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-colors"
                                                   title="Update Status">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-lg border border-gray-100 dark:border-gray-700 animate-bounce-in">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-100 to-green-50 dark:from-emerald-900/30 dark:to-green-800/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-calendar-times text-emerald-500 dark:text-emerald-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Bookings Yet</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-8">There are no bookings in the system yet.</p>
                        </div>
                    </div>
                    @endif

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
