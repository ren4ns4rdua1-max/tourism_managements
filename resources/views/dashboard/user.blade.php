@php
    use App\Models\User;
    use App\Models\Destination;
    use App\Models\Gallery;
    use App\Models\Feedback;
    use Illuminate\Support\Facades\DB;

    // Basic stats for users
    $totalDestinations = Destination::where('is_active', true)->count();
    $totalGallery = Gallery::count();

    // Fetch active destinations (limit 6)
    $destinations = Destination::where('is_active', true)
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();

    // Fetch recent gallery images (limit 6)
    $galleries = Gallery::orderBy('created_at', 'desc')
        ->limit(6)
        ->get();

    // Fetch recommendations - show featured destinations (random selection as recommendations)
    $recommendedDestinations = Destination::where('is_active', true)
        ->inRandomOrder()
        ->limit(4)
        ->get();
@endphp

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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

        @include('layouts.sidebar-user')

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
            <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-800">
                <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Tourism Portal</h1>
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
                                User Dashboard
                            </h2>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                Welcome back, <span class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                            </p>
                        </div>

                        <button id="darkModeToggle" onclick="toggleDarkMode()"
                            class="group relative p-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                                   hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-lg hover:shadow-blue-500/20
                                   dark:hover:shadow-blue-500/10 transition-all duration-300">
                            <svg id="lightModeIcon" class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <svg id="darkModeIcon" class="w-5 h-5 text-blue-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <div class="relative bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600
                                rounded-2xl shadow-2xl shadow-blue-500/20 p-8 sm:p-10 text-white overflow-hidden
                                border border-white/10">
                        <!-- Animated background patterns -->
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-white/10 to-transparent rounded-full blur-3xl -translate-y-32 translate-x-32 animate-pulse"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-indigo-500/20 to-transparent rounded-full blur-2xl translate-y-20 -translate-x-20"></div>

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
                            <p class="text-blue-100 mt-3 text-base sm:text-lg font-medium">
                                Explore amazing destinations and discover new places
                            </p>
                            <div class="mt-6 flex flex-wrap gap-4">
                                <div class="inline-flex items-center bg-white/15 backdrop-blur-md px-5 py-3 rounded-xl border border-white/30 shadow-lg">
                                    <svg class="w-5 h-5 mr-2 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm sm:text-base font-semibold">{{ now()->format('l, F j, Y') }}</span>
                                </div>
                                <div class="inline-flex items-center bg-white/15 backdrop-blur-md px-5 py-3 rounded-xl border border-white/30 shadow-lg">
                                    <svg class="w-5 h-5 mr-2 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm sm:text-base font-semibold">{{ now()->format('g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                        <div class="relative group bg-white dark:bg-gray-800
                                    border-2 border-blue-300 dark:border-blue-700
                                    rounded-2xl shadow-lg hover:shadow-2xl
                                    transition-all duration-500 p-6
                                    hover:-translate-y-2 overflow-hidden">

                            <div class="flex justify-between items-start mb-4 relative z-10">
                                <div>
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">
                                        Available Destinations
                                    </span>
                                    <p class="text-4xl font-black text-gray-900 dark:text-white mt-2 tracking-tight">
                                        {{ number_format($totalDestinations) }}
                                    </p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg
                                            group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-center mt-4 relative z-10">
                                <div class="flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                    <span class="text-sm font-bold">Explore</span>
                                </div>
                                <span class="text-sm text-gray-800 dark:text-gray-200 ml-3 font-semibold">
                                    Ready for you
                                </span>
                            </div>
                        </div>

                        <div class="relative group bg-white dark:bg-gray-800
                                    border-2 border-purple-300 dark:border-purple-700
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
                                <div class="p-3.5 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 text-white shadow-lg
                                            group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-center mt-4 relative z-10">
                                <div class="flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-md">
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
                            <a href="{{ route('gallery.index') }}"
                                class="group relative p-5 bg-white dark:bg-gray-800
                                       border-2 border-purple-300 dark:border-purple-700 rounded-xl hover:shadow-xl hover:shadow-purple-500/20
                                       transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                <div class="flex flex-col items-center text-center relative z-10">
                                    <div class="p-3.5 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 text-white mb-3 shadow-lg group-hover:scale-110 transition-transform">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="font-black text-base text-gray-900 dark:text-white">Browse Gallery</span>
                                    <span class="text-xs text-gray-800 dark:text-gray-200 font-semibold mt-1">View photos</span>
                                </div>
                            </a>

                            <a href="{{ route('destinations.index') }}"
                                class="group relative p-5 bg-white dark:bg-gray-800
                                       border-2 border-blue-300 dark:border-blue-700 rounded-xl hover:shadow-xl hover:shadow-blue-500/20
                                       transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                <div class="flex flex-col items-center text-center relative z-10">
                                    <div class="p-3.5 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white mb-3 shadow-lg group-hover:scale-110 transition-transform">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                        </svg>
                                    </div>
                                    <span class="font-black text-base text-gray-900 dark:text-white">Explore Destinations</span>
                                    <span class="text-xs text-gray-800 dark:text-gray-200 font-semibold mt-1">Find places</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Recommended Destinations Section -->
                    @if($recommendedDestinations->count() > 0)
                    <div class="bg-white dark:bg-gray-800 border-2 border-amber-300 dark:border-amber-600
                                rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="p-2.5 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white mr-3 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        Recommended for You
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        Top-rated destinations based on customer reviews
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('destinations.index') }}" class="text-sm font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300">
                                View All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($recommendedDestinations as $destination)
                            <div class="group relative bg-gray-50 dark:bg-gray-700 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300">
                                <div class="relative h-32 overflow-hidden">
                                    @if($destination->image)
                                        <img src="{{ asset('storage/' . $destination->image) }}" 
                                             alt="{{ $destination->name }}"
                                             class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-32 bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2">
                                        <span class="px-2 py-1 bg-amber-500 text-white text-xs font-bold rounded-full flex items-center">
                                            <i class="fas fa-star mr-1"></i> {{ number_format($destination->feedbacks_avg_rating ?? 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm truncate">{{ $destination->name }}</h4>
                                    <p class="text-xs text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                        <i class="fas fa-location-dot mr-1 text-red-500"></i>
                                        {{ $destination->location }}
                                    </p>
                                    @if($destination->price)
                                        <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400 mt-2">
                                            ₱{{ number_format($destination->price, 2) }}
                                        </p>
                                    @endif
                                </div>
                                <a href="{{ route('destinations.index') }}" class="absolute inset-0"></a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Destinations Section -->
                    @if($destinations->count() > 0)
                    <div class="bg-white dark:bg-gray-800 border-2 border-blue-300 dark:border-blue-700
                                rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="p-2.5 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white mr-3 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        Popular Destinations
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        Explore our amazing travel destinations
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('destinations.index') }}" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                View All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($destinations as $destination)
                            <div class="group relative bg-gray-50 dark:bg-gray-700 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300">
                                <div class="relative h-40 overflow-hidden">
                                    @if($destination->image)
                                        <img src="{{ asset('storage/' . $destination->image) }}" 
                                             alt="{{ $destination->name }}"
                                             class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-40 bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    @if($destination->is_active)
                                        <span class="absolute top-2 left-2 px-2 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full">
                                            <i class="fas fa-check-circle mr-1"></i> Active
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-gray-900 dark:text-white truncate">{{ $destination->name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                        <i class="fas fa-location-dot mr-1 text-red-500"></i>
                                        {{ $destination->location }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 line-clamp-2">
                                        {{ Str::limit($destination->description, 80) }}
                                    </p>
                                    @if($destination->price)
                                        <div class="flex items-center justify-between mt-3">
                                            <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                                ₱{{ number_format($destination->price, 2) }}
                                            </p>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">starting at</span>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('destinations.index') }}" class="absolute inset-0"></a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Gallery Section -->
                    @if($galleries->count() > 0)
                    <div class="bg-white dark:bg-gray-800 border-2 border-purple-300 dark:border-purple-700
                                rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="p-2.5 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 text-white mr-3 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        Photo Gallery
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        Explore our collection of memorable moments
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('gallery.index') }}" class="text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300">
                                View All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($galleries->take(6) as $gallery)
                            <div class="relative group overflow-hidden rounded-lg">
                                @if($gallery->image)
                                    <img src="{{ asset('storage/' . $gallery->image) }}" 
                                         alt="{{ $gallery->title ?? 'Gallery Image' }}"
                                         class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                @if($gallery->title)
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3">
                                        <p class="text-white text-sm font-medium truncate">{{ $gallery->title }}</p>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Feedback Form Section -->
                    <div class="bg-white dark:bg-gray-800 border-2 border-teal-300 dark:border-teal-600 rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="p-2.5 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-600 text-white mr-3 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        Share Your Feedback
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        We value your opinion! Let us know how we can improve
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Feedback Form -->
                        <form action="{{ route('dashboard.feedback.store') }}" method="POST" id="feedbackForm">
                            @csrf

                            <!-- Success Message -->
                            @if(session('success'))
                                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-800/20 border-l-4 border-green-500 rounded-xl p-4 shadow-md">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center mr-3">
                                            <i class="fas fa-check-circle text-white text-lg"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-green-800 dark:text-green-300 font-medium">{{ session('success') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Error Messages -->
                            @if($errors->any())
                                <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-800/20 border-l-4 border-red-500 rounded-xl p-4 shadow-md">
                                    <div class="flex items-start">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center mr-3 mt-0.5">
                                            <i class="fas fa-exclamation-circle text-white text-lg"></i>
                                        </div>
                                        <div class="flex-1">
                                            @foreach($errors->all() as $error)
                                                <p class="text-red-800 dark:text-red-300 text-sm">{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Star Rating -->
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">
                                    How would you rate your experience?
                                </label>
                                <div class="flex items-center space-x-2" id="starRating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" 
                                                class="star-btn focus:outline-none"
                                                data-rating="{{ $i }}"
                                                onclick="selectRating({{ $i }})">
                                            <svg class="w-10 h-10 transition-all duration-200 hover:scale-125 text-gray-300 dark:text-gray-600"
                                                 id="star-{{ $i }}"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                    <span class="ml-3 text-sm text-gray-600 dark:text-gray-400" id="ratingText"></span>
                                </div>
                                <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 0) }}">
                            </div>

                            <!-- Feedback Text -->
                            <div class="mb-6">
                                <label for="feedback_text" class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">
                                    Your Feedback <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="feedback_text" 
                                    name="feedback_text" 
                                    rows="4"
                                    class="w-full border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-teal-500 dark:focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 rounded-xl p-4 transition-all resize-none"
                                    placeholder="Tell us about your experience, what you liked, or how we can improve..."
                                    required
                                >{{ old('feedback_text') }}</textarea>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    Maximum 1000 characters
                                </p>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Submit Feedback
                                </button>
                            </div>
                        </form>
                    </div>

                    <script>
                        // Star rating functionality
                        let currentRating = {{ old('rating', 0) }};
                        
                        function selectRating(rating) {
                            currentRating = rating;
                            document.getElementById('ratingInput').value = rating;
                            updateStars();
                        }
                        
                        function updateStars() {
                            for (let i = 1; i <= 5; i++) {
                                const star = document.getElementById('star-' + i);
                                if (i <= currentRating) {
                                    star.classList.remove('text-gray-300', 'dark:text-gray-600');
                                    star.classList.add('text-yellow-400', 'fill-yellow-400');
                                } else {
                                    star.classList.remove('text-yellow-400', 'fill-yellow-400');
                                    star.classList.add('text-gray-300', 'dark:text-gray-600');
                                }
                            }
                            
                            const ratingText = document.getElementById('ratingText');
                            if (currentRating > 0) {
                                ratingText.textContent = currentRating + ' star' + (currentRating > 1 ? 's' : '');
                            } else {
                                ratingText.textContent = '';
                            }
                        }
                        
                        // Initialize stars on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            updateStars();
                        });
                    </script>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
