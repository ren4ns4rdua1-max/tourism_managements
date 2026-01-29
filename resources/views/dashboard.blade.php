@php
    use App\Models\User;
    use App\Models\Destination;
    use App\Models\Gallery;
    use Illuminate\Support\Facades\DB;

    // Core stats
    $totalUsers = User::count();
    $totalDestinations = Destination::where('is_active', true)->count();
    $totalGallery = Gallery::count();
    $activeSessions = 1249;

    // Get data for charts
    $usersByMonth = User::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as count')
    )
    ->whereYear('created_at', date('Y'))
    ->groupBy('month')
    ->orderBy('month')
    ->get()
    ->pluck('count', 'month');

    $destinationsByStatus = [
        'active' => Destination::where('is_active', true)->count(),
        'inactive' => Destination::where('is_active', false)->count(),
    ];

    $stats = [
        [
            'title' => 'Total Users',
            'value' => $totalUsers,
            'change' => '+12.5%',
            'changeType' => 'increase',
            'icon' => 'users',
            'gradient' => 'from-violet-500 via-purple-500 to-fuchsia-500',
            'icon_bg' => 'bg-gradient-to-br from-violet-500 to-purple-600',
            'bg_color' => 'bg-white dark:bg-gray-800',
            'border_color' => 'border-violet-300 dark:border-violet-700',
            'text_color' => 'text-violet-600 dark:text-violet-400',
            'trend' => 'up'
        ],
        [
            'title' => 'Active Destinations',
            'value' => $totalDestinations,
            'change' => '+8.2%',
            'changeType' => 'increase',
            'icon' => 'map-pin',
            'gradient' => 'from-emerald-500 via-teal-500 to-cyan-500',
            'icon_bg' => 'bg-gradient-to-br from-emerald-500 to-teal-600',
            'bg_color' => 'bg-white dark:bg-gray-800',
            'border_color' => 'border-emerald-300 dark:border-emerald-700',
            'text_color' => 'text-emerald-600 dark:text-emerald-400',
            'trend' => 'up'
        ],
        [
            'title' => 'Gallery Items',
            'value' => $totalGallery,
            'change' => '+15.3%',
            'changeType' => 'increase',
            'icon' => 'camera',
            'gradient' => 'from-rose-500 via-pink-500 to-fuchsia-500',
            'icon_bg' => 'bg-gradient-to-br from-rose-500 to-pink-600',
            'bg_color' => 'bg-white dark:bg-gray-800',
            'border_color' => 'border-rose-300 dark:border-rose-700',
            'text_color' => 'text-rose-600 dark:text-rose-400',
            'trend' => 'up'
        ],
        [
            'title' => 'Active Sessions',
            'value' => $activeSessions,
            'change' => '+23.1%',
            'changeType' => 'increase',
            'icon' => 'eye',
            'gradient' => 'from-amber-500 via-orange-500 to-red-500',
            'icon_bg' => 'bg-gradient-to-br from-amber-500 to-orange-600',
            'bg_color' => 'bg-white dark:bg-gray-800',
            'border_color' => 'border-amber-300 dark:border-amber-700',
            'text_color' => 'text-amber-600 dark:text-amber-400',
            'trend' => 'up'
        ],
    ];

    // Generate chart data
    $monthlyUserData = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthlyUserData[] = $usersByMonth[$i] ?? 0;
    }

    $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
@endphp

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="h-full bg-gray-100 dark:bg-gray-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
                <!-- Logo/Brand Section -->
                <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-gray-800 dark:to-gray-800">
                    <h1 class="text-xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">Tourism Admin</h1>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 overflow-y-auto py-4">
                    <div class="px-4 space-y-2">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-medium">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('gallery.index') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Gallery</span>
                        </a>

                        <a href="{{ route('destinations.index') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Destination</span>
                        </a>

                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Booking</span>
                        </a>

                        <a href="{{ route('users.index') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>Users</span>
                        </a>

                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <span>Feedback</span>
                        </a>
                    </div>
                </nav>

                <!-- User Profile Section at Bottom -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" 
                                class="flex items-center w-full px-4 py-3 text-left rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white font-medium shadow-lg">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-200 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="dropdownOpen" 
                             @click.away="dropdownOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute bottom-full left-0 w-full mb-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
                             style="display: none;">
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile
                                </div>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Log Out
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile Menu Button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="p-2 rounded-lg bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none border border-gray-200 dark:border-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': sidebarOpen, 'inline-flex': !sidebarOpen}" 
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 6h16M4 12h16M4 18h16"></path>
                    <path :class="{'hidden': !sidebarOpen, 'inline-flex': sidebarOpen}" 
                          class="hidden"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40"
             style="display: none;">
        </div>

        <!-- Mobile Sidebar -->
        <aside x-show="sidebarOpen"
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="lg:hidden fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-800 shadow-lg z-50 border-r border-gray-200 dark:border-gray-700"
               style="display: none;">
            <!-- Same content as desktop sidebar -->
            <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-gray-800 dark:to-gray-800">
                <h1 class="text-xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">Tourism Admin</h1>
            </div>
            <nav class="flex-1 overflow-y-auto py-4 h-[calc(100vh-8rem)]">
                <div class="px-4 space-y-2">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-medium">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('gallery.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Gallery</span>
                    </a>
                    <a href="{{ route('destinations.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Destination</span>
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Booking</span>
                    </a>
                    <a href="{{ route('users.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>Users</span>
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        <span>Feedback</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
            <!-- Header with Dark Mode Toggle -->
            <div class="sticky top-0 z-30 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex justify-between items-center">
                        <div class="pl-12 lg:pl-0">
                            <h2 class="font-bold text-3xl text-gray-900 dark:text-white">
                                Dashboard
                            </h2>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                Welcome back, <span class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                            </p>
                        </div>

                        <button id="darkModeToggle" onclick="toggleDarkMode()"
                            class="group relative p-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 
                                   hover:border-violet-300 dark:hover:border-violet-600 hover:shadow-lg hover:shadow-violet-500/20 
                                   dark:hover:shadow-violet-500/10 transition-all duration-300">
                            <svg id="lightModeIcon" class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <svg id="darkModeIcon" class="w-5 h-5 text-violet-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                Toggle theme
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

                    <!-- Welcome Banner with Enhanced Design -->
                    <div class="relative bg-gradient-to-r from-violet-600 via-purple-600 to-fuchsia-600
                                rounded-2xl shadow-2xl shadow-purple-500/20 p-8 sm:p-10 text-white overflow-hidden
                                border border-white/10">
                        <!-- Animated background patterns -->
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-white/10 to-transparent rounded-full blur-3xl -translate-y-32 translate-x-32 animate-pulse"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-fuchsia-500/20 to-transparent rounded-full blur-2xl translate-y-20 -translate-x-20"></div>
                        
                        <!-- Decorative elements -->
                        <div class="absolute top-10 right-20 w-20 h-20 border-4 border-white/20 rounded-full"></div>
                        <div class="absolute bottom-10 right-40 w-12 h-12 border-4 border-white/20 rounded-lg rotate-45"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <h1 class="text-3xl sm:text-4xl font-bold text-white drop-shadow-lg">
                                    Welcome back, {{ Auth::user()->name }}! 👋
                                </h1>
                            </div>
                            <p class="text-purple-100 mt-3 text-base sm:text-lg font-medium">
                                Here's what's happening with your tourism platform today
                            </p>
                            <div class="mt-6 flex flex-wrap gap-4">
                                <div class="inline-flex items-center bg-white/15 backdrop-blur-md px-5 py-3 rounded-xl border border-white/30 shadow-lg">
                                    <svg class="w-5 h-5 mr-2 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm sm:text-base font-semibold">{{ now()->format('l, F j, Y') }}</span>
                                </div>
                                <div class="inline-flex items-center bg-white/15 backdrop-blur-md px-5 py-3 rounded-xl border border-white/30 shadow-lg">
                                    <svg class="w-5 h-5 mr-2 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm sm:text-base font-semibold">{{ now()->format('g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($stats as $stat)
                            <div class="relative group {{ $stat['bg_color'] }} 
                                        border-2 {{ $stat['border_color'] }}
                                        rounded-2xl shadow-lg hover:shadow-2xl 
                                        transition-all duration-500 p-6
                                        hover:-translate-y-2 overflow-hidden">
                                
                                <div class="flex justify-between items-start mb-4 relative z-10">
                                    <div>
                                        <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">
                                            {{ $stat['title'] }}
                                        </span>
                                        <p class="text-4xl font-black text-gray-900 dark:text-white mt-2 tracking-tight">
                                            {{ number_format($stat['value']) }}
                                        </p>
                                    </div>
                                    <div class="p-3.5 rounded-xl {{ $stat['icon_bg'] }} text-white shadow-lg 
                                                group-hover:scale-110 transition-transform duration-300">
                                        @if($stat['icon'] === 'users')
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0h-1m-10 0a4 4 0 100-8 4 4 0 000 8z"/>
                                            </svg>
                                        @elseif($stat['icon'] === 'map-pin')
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        @elseif($stat['icon'] === 'camera')
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        @else
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center mt-4 relative z-10">
                                    <div class="flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                        </svg>
                                        <span class="text-sm font-bold">{{ $stat['change'] }}</span>
                                    </div>
                                    <span class="text-sm text-gray-800 dark:text-gray-200 ml-3 font-semibold">
                                        vs last month
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Charts Section with Enhanced Design -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- User Growth Chart -->
                        <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700
                                    rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-6">
                                <div class="mb-4 sm:mb-0">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        User Growth Trend
                                    </h3>
                                    <p class="text-sm text-gray-800 dark:text-gray-200 mt-1 font-medium">Monthly user registrations this year</p>
                                </div>
                                <div class="text-left sm:text-right bg-white dark:bg-gray-700 px-4 py-3 rounded-xl border-2 border-violet-300 dark:border-violet-700 shadow-md">
                                    <p class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($totalUsers) }}</p>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Total Users</p>
                                </div>
                            </div>
                            
                            <div class="h-64 bg-gradient-to-t from-gray-50 to-transparent dark:from-gray-900/50 dark:to-transparent rounded-xl p-4">
                                <div class="flex items-end h-48 space-x-2">
                                    @foreach($monthlyUserData as $index => $count)
                                        <div class="flex flex-col items-center flex-1 group cursor-pointer">
                                            @php
                                                $maxValue = max(array_merge($monthlyUserData, [1]));
                                                $height = max(10, ($count / $maxValue) * 100);
                                                $colors = ['from-violet-400 to-purple-600', 'from-purple-400 to-fuchsia-600', 'from-fuchsia-400 to-pink-600'];
                                                $colorGradient = $colors[$index % 3];
                                            @endphp
                                            <div class="relative w-full">
                                                <div 
                                                    class="w-full bg-gradient-to-t {{ $colorGradient }} 
                                                           rounded-t-xl transition-all duration-500 hover:opacity-80
                                                           group-hover:shadow-xl shadow-purple-500/50"
                                                    style="height: {{ $height }}%"
                                                ></div>
                                            </div>
                                            <div class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-2">{{ $monthNames[$index] }}</div>
                                            <div class="text-xs font-bold text-white dark:text-gray-900 mt-1 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-900 dark:bg-white px-2 py-1 rounded shadow-lg">
                                                {{ $count }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Destinations Status Chart -->
                        <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700
                                    rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
                                Destinations Overview
                            </h3>
                            
                            <div class="flex flex-col lg:flex-row items-center justify-center h-64">
                                <div class="relative w-48 h-48 mb-6 lg:mb-0 lg:mr-8">
                                    @php
                                        $total = $destinationsByStatus['active'] + $destinationsByStatus['inactive'];
                                        $activePercentage = $total > 0 ? ($destinationsByStatus['active'] / $total) * 100 : 0;
                                    @endphp
                                    <!-- Enhanced donut chart -->
                                    <svg class="transform -rotate-90 w-48 h-48" viewBox="0 0 100 100">
                                        <!-- Background circle -->
                                        <circle cx="50" cy="50" r="40" fill="none" stroke="#e5e7eb" stroke-width="12" class="dark:stroke-gray-700"/>
                                        <!-- Active percentage arc -->
                                        <circle cx="50" cy="50" r="40" fill="none" 
                                                stroke="url(#gradient-active)" 
                                                stroke-width="12" 
                                                stroke-dasharray="{{ $activePercentage * 2.51 }} 251"
                                                stroke-linecap="round"
                                                class="transition-all duration-1000"/>
                                        <defs>
                                            <linearGradient id="gradient-active" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" style="stop-color:#10b981"/>
                                                <stop offset="100%" style="stop-color:#14b8a6"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="text-center">
                                            <p class="text-4xl font-black text-gray-900 dark:text-white">
                                                {{ round($activePercentage) }}%
                                            </p>
                                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Active</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center p-4 rounded-xl bg-white dark:bg-gray-700 border-2 border-emerald-300 dark:border-emerald-700 shadow-md hover:shadow-lg transition-shadow">
                                        <div class="w-4 h-4 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 mr-3 shadow-lg"></div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900 dark:text-white">Active Destinations</p>
                                            <p class="text-xs text-gray-800 dark:text-gray-200 font-semibold">Ready for visitors</p>
                                        </div>
                                        <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $destinationsByStatus['active'] }}</p>
                                    </div>
                                    <div class="flex items-center p-4 rounded-xl bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 shadow-md hover:shadow-lg transition-shadow">
                                        <div class="w-4 h-4 rounded-full bg-gray-500 dark:bg-gray-400 mr-3 shadow-lg"></div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900 dark:text-white">Inactive</p>
                                            <p class="text-xs text-gray-800 dark:text-gray-200 font-semibold">Under maintenance</p>
                                        </div>
                                        <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $destinationsByStatus['inactive'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity & Quick Actions with Enhanced Design -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Recent Activity -->
                        <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700
                                    rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    Recent Activity
                                </h3>
                                <span class="px-3 py-1 bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 text-xs font-bold rounded-full">
                                    Live
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center p-4 hover:bg-blue-50 dark:hover:bg-gray-700
                                            rounded-xl transition-all duration-300 border-2 border-transparent hover:border-blue-300 dark:hover:border-blue-700 group">
                                    <div class="p-3 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 ml-4">
                                        <p class="font-bold text-gray-900 dark:text-white">New user registered</p>
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">2 hours ago</p>
                                    </div>
                                    <span class="text-sm font-black text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 rounded-full">+1</span>
                                </div>

                                <div class="flex items-center p-4 hover:bg-green-50 dark:hover:bg-gray-700
                                            rounded-xl transition-all duration-300 border-2 border-transparent hover:border-green-300 dark:hover:border-green-700 group">
                                    <div class="p-3 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 ml-4">
                                        <p class="font-bold text-gray-900 dark:text-white">Destination updated</p>
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">Yesterday, 4:30 PM</p>
                                    </div>
                                    <span class="text-sm font-black text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/30 px-3 py-1 rounded-full">Updated</span>
                                </div>

                                <div class="flex items-center p-4 hover:bg-purple-50 dark:hover:bg-gray-700
                                            rounded-xl transition-all duration-300 border-2 border-transparent hover:border-purple-300 dark:hover:border-purple-700 group">
                                    <div class="p-3 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 text-white shadow-lg group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 ml-4">
                                        <p class="font-bold text-gray-900 dark:text-white">Gallery photo uploaded</p>
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">Yesterday, 11:20 AM</p>
                                    </div>
                                    <span class="text-sm font-black text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-900/30 px-3 py-1 rounded-full">+5</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700
                                    rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    Quick Actions
                                </h3>
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('users.index') }}"
                                    class="group relative p-5 bg-white dark:bg-gray-800
                                           border-2 border-violet-300 dark:border-violet-700 rounded-xl hover:shadow-xl hover:shadow-violet-500/20
                                           transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                    <div class="flex flex-col items-center text-center relative z-10">
                                        <div class="p-3.5 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 text-white mb-3 shadow-lg group-hover:scale-110 transition-transform">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                            </svg>
                                        </div>
                                        <span class="font-black text-base text-gray-900 dark:text-white">Manage Users</span>
                                        <span class="text-xs text-gray-800 dark:text-gray-200 font-semibold mt-1">Add or edit users</span>
                                    </div>
                                </a>
                                
                                <a href="{{ route('gallery.create') }}"
                                    class="group relative p-5 bg-white dark:bg-gray-800
                                           border-2 border-rose-300 dark:border-rose-700 rounded-xl hover:shadow-xl hover:shadow-rose-500/20
                                           transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                    <div class="flex flex-col items-center text-center relative z-10">
                                        <div class="p-3.5 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 text-white mb-3 shadow-lg group-hover:scale-110 transition-transform">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <span class="font-black text-base text-gray-900 dark:text-white">Upload Photos</span>
                                        <span class="text-xs text-gray-800 dark:text-gray-200 font-semibold mt-1">Add to gallery</span>
                                    </div>
                                </a>
                                
                                <a href="{{ route('destinations.index') }}"
                                    class="group relative p-5 bg-white dark:bg-gray-800
                                           border-2 border-emerald-300 dark:border-emerald-700 rounded-xl hover:shadow-xl hover:shadow-emerald-500/20
                                           transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                    <div class="flex flex-col items-center text-center relative z-10">
                                        <div class="p-3.5 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white mb-3 shadow-lg group-hover:scale-110 transition-transform">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                            </svg>
                                        </div>
                                        <span class="font-black text-base text-gray-900 dark:text-white">Destinations</span>
                                        <span class="text-xs text-gray-800 dark:text-gray-200 font-semibold mt-1">Manage locations</span>
                                    </div>
                                </a>
                                
                                <a href="#"
                                    class="group relative p-5 bg-white dark:bg-gray-800
                                           border-2 border-amber-300 dark:border-amber-700 rounded-xl hover:shadow-xl hover:shadow-amber-500/20
                                           transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                    <div class="flex flex-col items-center text-center relative z-10">
                                        <div class="p-3.5 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white mb-3 shadow-lg group-hover:scale-110 transition-transform">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <span class="font-black text-base text-gray-900 dark:text-white">Settings</span>
                                        <span class="text-xs text-gray-800 dark:text-gray-200 font-semibold mt-1">Configuration</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <!-- Enhanced Dark Mode Script -->
    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const lightIcon = document.getElementById('lightModeIcon');
            const darkIcon = document.getElementById('darkModeIcon');
            const darkModeToggle = document.getElementById('darkModeToggle');
            
            html.classList.toggle('dark');
            lightIcon.classList.toggle('hidden');
            darkIcon.classList.toggle('hidden');
            
            darkModeToggle.classList.add('scale-95');
            setTimeout(() => {
                darkModeToggle.classList.remove('scale-95');
            }, 150);
            
            const isDark = html.classList.contains('dark');
            localStorage.setItem('darkMode', isDark);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const savedDarkMode = localStorage.getItem('darkMode');
            const lightIcon = document.getElementById('lightModeIcon');
            const darkIcon = document.getElementById('darkModeIcon');
            
            if (savedDarkMode === 'true') {
                document.documentElement.classList.add('dark');
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            } else if (savedDarkMode === 'false') {
                document.documentElement.classList.remove('hidden');
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
                localStorage.setItem('darkMode', 'true');
            }
        });
        
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('darkMode')) {
                if (e.matches) {
                    document.documentElement.classList.add('dark');
                    document.getElementById('lightModeIcon').classList.add('hidden');
                    document.getElementById('darkModeIcon').classList.remove('hidden');
                } else {
                    document.documentElement.classList.remove('dark');
                    document.getElementById('lightModeIcon').classList.remove('hidden');
                    document.getElementById('darkModeIcon').classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>