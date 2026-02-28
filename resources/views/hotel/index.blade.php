@php
    use App\Models\Hotel;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management | Travel Management</title>
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
                        'bounce-in': 'bounceIn 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.9)', opacity: '0' },
                            '70%': { transform: 'scale(1.05)' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
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
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
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
                                    Hotel Management
                                    <span class="ml-3 text-xs bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 font-bold px-3 py-1 rounded-full">ADMIN</span>
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
                                       placeholder="Search hotels...">
                            </div>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <!-- Add Hotel Button -->
                            <a href="{{ route('hotel.create') }}"
                                class="bg-gradient-to-r from-amber-600 to-orange-500 hover:from-amber-700 hover:to-orange-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3 group">
                                <i class="fas fa-plus-circle text-lg"></i>
                                Add Hotel
                                <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto">
                    
                    <!-- Alerts Section -->
                    @if(session('success') || $errors->any())
                    <div class="mb-8">
                        @if(session('success'))
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
                        @endif

                        @if($errors->any())
                        <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-lg animate-fade-in mt-4">
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
                        @endif
                    </div>
                    @endif

                    <!-- Hotels Header -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">All Hotels</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">Manage your hotel properties</p>
                        </div>
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            <select class="appearance-none bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 pl-4 pr-10 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-primary-500">
                                <option>All Hotels</option>
                                <option>Active Only</option>
                                <option>Inactive Only</option>
                            </select>
                            <button class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-filter text-lg"></i>
                            </button>
                            <button class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-th-large text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Hotels Grid -->
                    @if($hotels->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($hotels as $index => $hotel)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700 animate-fade-in"
                             style="animation-delay: {{ $index * 0.05 }}s">
                            
                            <!-- Hotel Image/Header -->
                            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-violet-100 to-purple-50 dark:from-violet-900/30 dark:to-purple-800/30">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-20 h-20 rounded-2xl bg-white/80 dark:bg-gray-800/80 flex items-center justify-center shadow-lg">
                                        <i class="fas fa-hotel text-4xl text-violet-600 dark:text-violet-400"></i>
                                    </div>
                                </div>
                                
                                <!-- Star Rating -->
                                <div class="absolute top-4 left-4">
                                    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-lg">
                                        <div class="flex items-center">
                                            @for($i = 0; $i < $hotel->star_rating; $i++)
                                                <i class="fas fa-star text-amber-400 text-sm"></i>
                                            @endfor
                                            @for($i = $hotel->star_rating; $i < 5; $i++)
                                                <i class="fas fa-star text-gray-300 text-sm"></i>
                                            @endfor
                                            <span class="ml-2 text-xs font-bold text-gray-700 dark:text-gray-300">{{ $hotel->star_rating }} Star</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    @if($hotel->status == 'active')
                                    <span class="px-3 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    </span>
                                    @elseif($hotel->status == 'inactive')
                                    <span class="px-3 py-1.5 bg-gray-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="fas fa-pause-circle mr-1"></i> Inactive
                                    </span>
                                    @else
                                    <span class="px-3 py-1.5 bg-amber-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="fas fa-tools mr-1"></i> Maintenance
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 dark:text-white text-xl mb-2">{{ $hotel->name }}</h3>
                                
                                <div class="flex items-center text-gray-600 dark:text-gray-300 text-sm mb-3">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                    <span class="font-medium">{{ $hotel->city }}, {{ $hotel->country }}</span>
                                </div>

                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($hotel->description, 100) }}
                                </p>

                                <!-- Contact Info -->
                                <div class="flex items-center space-x-4 mb-4 text-sm text-gray-500 dark:text-gray-400">
                                    @if($hotel->phone)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone-alt mr-2"></i>
                                        <span>{{ $hotel->phone }}</span>
                                    </div>
                                    @endif
                                </div>

                                <!-- Room Count -->
                                <div class="flex items-center justify-between mb-4 py-3 border-t border-b border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-door-open text-blue-600 dark:text-blue-400 text-sm"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $hotel->rooms->count() }} Rooms</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-bed text-green-600 dark:text-green-400 text-sm"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $hotel->rooms->where('status', 'available')->count() }} Available</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2 pt-2">
                                    <a href="{{ route('hotel.show', $hotel) }}" 
                                       class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 text-center shadow-md hover:shadow-lg">
                                        <i class="fas fa-eye mr-2"></i>View
                                    </a>
                                    <a href="{{ route('hotel.edit', $hotel) }}" 
                                       class="flex-1 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 text-center shadow-md hover:shadow-lg">
                                        <i class="fas fa-edit mr-2"></i>Edit
                                    </a>
                                    <a href="{{ route('hotel.bookings.create') }}?hotel_id={{ $hotel->id }}" 
                                       class="flex-1 bg-violet-500 hover:bg-violet-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 text-center shadow-md hover:shadow-lg">
                                        <i class="fas fa-calendar-plus mr-2"></i>Book
                                    </a>
                                    <form action="{{ route('hotel.destroy', $hotel) }}" method="POST" onsubmit="return confirm('Delete this hotel?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-lg border border-gray-100 dark:border-gray-700 animate-bounce-in">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-amber-100 to-orange-50 dark:from-amber-900/30 dark:to-orange-800/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-hotel text-amber-500 dark:text-amber-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Hotels Yet</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-8">Start adding hotels for your guests to book!</p>
                            <a href="{{ route('hotel.create') }}"
                                class="bg-gradient-to-r from-amber-600 to-orange-500 hover:from-amber-700 hover:to-orange-600 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-3">
                                <i class="fas fa-plus-circle text-lg"></i>
                                Add Your First Hotel
                            </a>
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
