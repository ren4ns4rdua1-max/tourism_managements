@php
    use App\Models\User;
    use App\Models\Destination;
    use App\Models\Gallery;
    use Illuminate\Support\Facades\DB;

    // Manager stats
    $totalUsers = User::count();
    $totalDestinations = Destination::where('is_active', true)->count();
    $totalGallery = Gallery::count();

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
    <title>Manager Dashboard</title>
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

        @include('layouts.sidebar-manager')

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
            <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-800">
                <h1 class="text-xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Manager Panel</h1>
            </div>
            <nav class="flex-1 overflow-y-auto py-4 h-[calc(100vh-8rem)]">
                <div class="px-4 space-y-2">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 font-medium">
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
                                Manager Dashboard
                            </h2>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                Welcome back, <span class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                            </p>
                        </div>

                        <button id="darkModeToggle" onclick="toggleDarkMode()"
                            class="group relative p-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                                   hover:border-green-300 dark:hover:border-green-600 hover:shadow-lg hover:shadow-green-500/20
                                   dark:hover:shadow-green-500/10 transition-all duration-300">
                            <svg id="lightModeIcon" class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <svg id="darkModeIcon" class="w-5 h-5 text-green-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                    <!-- Welcome Banner -->
                    <div class="relative bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600
                                rounded-2xl shadow-2xl shadow-green-500/20 p-8 sm:p-10 text-white overflow-hidden
                                border border-white/10">
                        <!-- Animated background patterns -->
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-white/10 to-transparent rounded-full blur-3xl -translate-y-32 translate-x-32 animate-pulse"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-emerald-500/20 to-transparent rounded-full blur-2xl translate-y-20 -translate-x-20"></div>

                        <!-- Decorative elements -->
                        <div class="absolute top-10 right-20 w-20 h-20 border-4 border-white/20 rounded-full"></div>
                        <div class="absolute bottom-10 right-40 w-12 h-12 border-4 border-white/20 rounded-lg rotate-45"></div>

                        <div class="relative z-10">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h1 class="text-3xl sm:text-4xl font-bold text-white drop-shadow-lg">
                                    Welcome back, {{ Auth::user()->name }}! 👋
                                </h1>
                            </div>
                            <p class="text-green-100 mt-3 text-base sm:text-lg font-medium">
                                Manage your tourism operations effectively
                            </p>
                            <div class="mt-6 flex flex-wrap gap-4">
                                <div class="inline-flex items-center bg-white/15 backdrop-blur-md px-5 py-3 rounded-xl border border-white/30 shadow-lg">
                                    <svg class="w-5 h-5 mr-2 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm sm:text-base font-semibold">{{ now()->format('l, F j, Y') }}</span>
                                </div>
                                <div class="inline-flex items-center bg-white/15 backdrop-blur-md px-5 py-3 rounded-xl border border-white/30 shadow-lg">
                                    <svg class="w-5 h-5 mr-2 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm sm:text-base font-semibold">{{ now()->format('g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="relative group bg-white dark:bg-gray-800
                                    border-2 border-green-300 dark:border-green-700
                                    rounded-2xl shadow-lg hover:shadow-2xl
                                    transition-all duration-500 p-6
                                    hover:-translate-y-2 overflow-hidden">

                            <div class="flex justify-between items-start mb-4 relative z-10">
                                <div>
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">
                                        Total Users
                                    </span>
                                    <p class="text-4xl font-black text-gray-900 dark:text-white mt-2 tracking-tight">
                                        {{ number_format($totalUsers) }}
                                    </p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg
                                            group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-center mt-4 relative z-10">
                                <div class="flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                    <span class="text-sm font-bold">Growing</span>
                                </div>
                                <span class="text-sm text-gray-800 dark:text-gray-200 ml-3 font-semibold">
                                    Community expanding
                                </span>
                            </div>
                        </div>

                        <div class="relative group bg-white dark:bg-gray-800
                                    border-2 border-emerald-300 dark:border-emerald-700
                                    rounded-2xl shadow-lg hover:shadow-2xl
                                    transition-all duration-500 p-6
                                    hover:-translate-y-2 overflow-hidden">

                            <div class="flex justify-between items-start mb-4 relative z-10">
                                <div>
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">
                                        Active Destinations
                                    </span>
                                    <p class="text-4xl font-black text-gray-900 dark:text-white mt-2 tracking-tight">
                                        {{ number_format($totalDestinations) }}
                                    </p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg
                                            group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-center mt-4 relative z-10">
                                <div class="flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-md">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-bold">Active</span>
                                </div>
                                <span class="text-sm text-gray-800 dark:text-gray-200 ml-3 font-semibold">
                                    Ready for visitors
                                </span>
                            </div>
                        </div>

                        <div class="relative group bg-white dark:bg-gray-800
                                    border-2 border-teal-300 dark:border-teal-700
                                    rounded-2xl shadow-lg hover:shadow-2xl
                                    transition-all duration-500 p-6
                                    hover:-translate-y-2 overflow-hidden">

                            <div class="flex justify-between items-start mb-4 relative z-10">
                                <div>
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">
                                        Gallery Items
                                    </span>
                                    <p class="text-4xl font-black text-gray-900 dark:text-white mt-2 tracking-tight">
                                        {{ number_format($totalGallery) }}
                                    </p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-600 text-white shadow-lg
                                            group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-center mt-4 relative z-10">
                                <div class="flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white shadow-md">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-bold">View</span>
                                </div>
                                <span class="text-sm text-gray-800 dark:text-gray-200 ml-3 font-semibold">
                                    Beautiful photos
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
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
                                <div class="text-left sm:text-right bg-white dark:bg-gray-700 px-4 py-3 rounded-xl border-2 border-green-300 dark:border-green-700 shadow-md">
                                    <p class="text-3xl font
