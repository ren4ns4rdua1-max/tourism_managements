@php
    use App\Models\User;
    use App\Models\Destination;
    use App\Models\Gallery;
    use App\Models\Booking;
    use Illuminate\Support\Facades\DB;

    $totalDestinations = Destination::where('is_active', true)->count();
    $totalGallery = Gallery::count();
    $availableDestinations = Destination::where('is_active', true)->orderBy('created_at', 'desc')->get();
    $galleryItems = Gallery::with('user')->latest()->get();
    $userBookings = Booking::with(['destination', 'hotel', 'room'])->where('user_id', Auth::id())->latest()->get();
@endphp

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Sora', 'sans-serif'],
                        serif: ['DM Serif Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --accent: #2563EB;
            --accent-warm: #F59E0B;
        }

        * { box-sizing: border-box; }

        body { font-family: 'Sora', sans-serif; }

        /* Grain overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
            background-size: 180px;
        }

        .dark body::before { opacity: 0.04; }

        /* Page fade-in */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.55s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .fade-up-1 { animation-delay: 0.05s; }
        .fade-up-2 { animation-delay: 0.12s; }
        .fade-up-3 { animation-delay: 0.20s; }
        .fade-up-4 { animation-delay: 0.28s; }

        /* Stat counter animation */
        @keyframes countUp {
            from { opacity: 0; transform: translateY(8px) scale(0.92); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .count-anim { animation: countUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s both; }

        /* Hover card lift */
        .card-hover {
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1),
                        box-shadow 0.35s ease;
        }
        .card-hover:hover { transform: translateY(-5px); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }

        /* Divider accent line */
        .accent-line {
            display: block;
            width: 36px;
            height: 3px;
            background: var(--accent);
            border-radius: 99px;
            margin-bottom: 1rem;
        }

        /* Action button glow */
        .btn-glow:hover {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.18);
        }

        /* Toggle pill animation */
        #themeToggle { transition: background 0.3s, box-shadow 0.3s; }
    </style>
</head>

<body class="h-full bg-slate-50 dark:bg-[#0d1117] text-gray-900 dark:text-gray-100 antialiased">
<div x-data="{ sidebarOpen: false }" class="relative flex h-screen overflow-hidden">

    <!-- Mobile hamburger -->
    <div class="lg:hidden fixed top-5 left-5 z-50">
        <button @click="sidebarOpen = !sidebarOpen"
                class="p-2.5 rounded-xl bg-white dark:bg-gray-800/90 shadow-lg border border-gray-200 dark:border-gray-700
                       text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path :class="{'hidden': sidebarOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{'hidden': !sidebarOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Main -->
    <main class="relative z-10 flex-1 overflow-y-auto">

        <!-- ── TOP NAVBAR ── -->
        <header class="sticky top-0 z-30 bg-white/75 dark:bg-[#0d1117]/80 backdrop-blur-xl
                       border-b border-gray-200/70 dark:border-gray-800">
            <div class="max-w-6xl mx-auto px-6 sm:px-8 h-16 flex items-center justify-between gap-4">

                <!-- Brand mark -->
                <div class="flex items-center gap-3 pl-10 lg:pl-0">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-md shadow-blue-500/30">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="hidden sm:block font-semibold text-sm tracking-tight text-gray-900 dark:text-white">Wandr</span>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Theme toggle -->
                    <button id="themeToggle" onclick="toggleDarkMode()"
                            class="relative w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800
                                   border border-gray-200 dark:border-gray-700
                                   flex items-center justify-center
                                   hover:bg-gray-200 dark:hover:bg-gray-700
                                   transition-colors duration-200">
                        <svg id="sunIcon" class="w-4.5 h-4.5 text-amber-500" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg id="moonIcon" class="w-4.5 h-4.5 text-blue-400 hidden" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    <!-- Divider -->
                    <div class="w-px h-6 bg-gray-200 dark:bg-gray-700 mx-1"></div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium
                                       text-red-600 dark:text-red-400
                                       bg-red-50 dark:bg-red-500/10
                                       hover:bg-red-100 dark:hover:bg-red-500/20
                                       border border-red-200 dark:border-red-500/20
                                       transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Log out</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- ── CONTENT ── -->
        <div class="max-w-6xl mx-auto px-6 sm:px-8 py-10 space-y-10">

            <!-- HERO BANNER -->
            <section class="fade-up fade-up-1 relative rounded-3xl overflow-hidden
                            bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800
                            dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900
                            shadow-2xl shadow-blue-500/20">

                <!-- Decorative circles -->
                <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-white/5 blur-2xl"></div>
                <div class="absolute -bottom-16 -left-16 w-56 h-56 rounded-full bg-indigo-400/10 blur-2xl"></div>
                <div class="absolute top-6 right-6 w-16 h-16 rounded-full border border-white/10"></div>
                <div class="absolute bottom-8 right-32 w-8 h-8 rounded-full border border-white/10"></div>

                <!-- Grid texture -->
                <div class="absolute inset-0 opacity-[0.04]"
                     style="background-image: linear-gradient(to right, #fff 1px, transparent 1px), linear-gradient(to bottom, #fff 1px, transparent 1px); background-size: 40px 40px;"></div>

                <div class="relative z-10 px-8 sm:px-12 py-10 sm:py-14">
                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
                        <div>
                            <p class="text-blue-200 text-sm font-medium tracking-widest uppercase mb-3">Your Dashboard</p>
                            <h1 class="font-serif text-4xl sm:text-5xl text-white leading-tight">
                                Hello, {{ Auth::user()->name }}! <span class="inline-block animate-bounce origin-bottom">👋</span>
                            </h1>
                            <p class="mt-3 text-blue-100/80 text-base max-w-md">
                                Ready to explore the world? Pick up where you left off.
                            </p>
                        </div>

                        <div class="flex flex-col gap-2 sm:text-right shrink-0">
                            <div class="inline-flex items-center gap-2 text-blue-100/90 text-sm font-medium">
                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ now()->format('l, F j, Y') }}
                            </div>
                            <div class="inline-flex items-center gap-2 text-blue-100/90 text-sm font-medium">
                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ now()->format('g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            >

            <!-- QUICK ACTIONS -->
            <section class="fade-up fade-up-3">
                <span class="accent-line" style="background:#F59E0B"></span>
                <h2 class="text-xs font-semibold tracking-widest text-gray-400 dark:text-gray-500 uppercase mb-5">Quick Actions</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <!-- Explore Destinations -->
                    <a href="{{ route('user.destinations.index') }}"
                       class="btn-glow card-hover group flex items-center gap-5 rounded-2xl
                              bg-white dark:bg-gray-900
                              border border-gray-200 dark:border-gray-800
                              shadow-sm p-6 transition-all duration-300">
                        <div class="shrink-0 w-14 h-14 rounded-2xl
                                    bg-gradient-to-br from-blue-500 to-indigo-600
                                    flex items-center justify-center shadow-lg shadow-blue-500/25
                                    group-hover:scale-105 group-hover:shadow-blue-500/40
                                    transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white text-base">Explore Destinations</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Discover new places to visit</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-blue-500 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- Browse Gallery -->
                    <a href="{{ route('user.gallery.index') }}"
                       class="btn-glow card-hover group flex items-center gap-5 rounded-2xl
                              bg-white dark:bg-gray-900
                              border border-gray-200 dark:border-gray-800
                              shadow-sm p-6 transition-all duration-300">
                        <div class="shrink-0 w-14 h-14 rounded-2xl
                                    bg-gradient-to-br from-purple-500 to-pink-600
                                    flex items-center justify-center shadow-lg shadow-purple-500/25
                                    group-hover:scale-105 group-hover:shadow-purple-500/40
                                    transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white text-base">Browse Gallery</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">View beautiful travel photos</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-purple-500 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                </div>
            </section>

            <!-- AVAILABLE DESTINATIONS TABLE -->
            <section class="fade-up fade-up-4">
                <span class="accent-line" style="background:#10B981"></span>
                <h2 class="text-xs font-semibold tracking-widest text-gray-400 dark:text-gray-500 uppercase mb-5">Available Destinations</h2>

                <div class="rounded-2xl overflow-hidden
                            bg-white dark:bg-gray-900
                            border border-gray-200 dark:border-gray-800
                            shadow-sm">
                    @if($availableDestinations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800">
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Destination</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach($availableDestinations as $destination)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center overflow-hidden">
                                                @if($destination->image)
                                                    <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <span class="font-semibold text-gray-900 dark:text-white text-sm">{{ $destination->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            {{ $destination->location }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($destination->price)
                                            <span class="font-semibold text-emerald-600 dark:text-emerald-400 text-sm">₱{{ number_format($destination->price, 2) }}</span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500 text-sm">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                                     bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('destinations.show', $destination) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                                  bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400
                                                  hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
                        <a href="{{ route('user.destinations.index') }}" 
                           class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:gap-3 transition-all">
                            View all {{ $availableDestinations->count() }} destinations
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">No destinations available yet</p>
                        <a href="{{ route('destinations.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 dark:text-blue-400">
                            Explore when available
                        </a>
                    </div>
                    @endif
                </div>
            </section>

            <!-- GALLERY ITEMS TABLE -->
            <section class="fade-up fade-up-4">
                <span class="accent-line" style="background:#8B5CF6"></span>
                <h2 class="text-xs font-semibold tracking-widest text-gray-400 dark:text-gray-500 uppercase mb-5">Gallery Items</h2>

                <div class="rounded-2xl overflow-hidden
                            bg-white dark:bg-gray-900
                            border border-gray-200 dark:border-gray-800
                            shadow-sm">
                    @if($galleryItems->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800">
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Photo</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Uploaded By</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach($galleryItems as $gallery)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center overflow-hidden">
                                            @if($gallery->image_path)
                                                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-gray-900 dark:text-white text-sm">{{ $gallery->title }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">{{ Str::limit($gallery->description, 50) ?? 'No description' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($gallery->user ? $gallery->user->name : 'U', 0, 1) }}
                                            </div>
                                            <span class="text-gray-700 dark:text-gray-300 text-sm">{{ $gallery->user ? $gallery->user->name : 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $gallery->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('user.gallery.index') }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                                  bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400
                                                  hover:bg-purple-100 dark:hover:bg-purple-500/20 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
                        <a href="{{ route('user.gallery.index') }}" 
                           class="inline-flex items-center gap-2 text-sm font-semibold text-purple-600 dark:text-purple-400 hover:gap-3 transition-all">
                            View all {{ $galleryItems->count() }} photos
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">No gallery items yet</p>
                        <a href="{{ route('user.gallery.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-purple-600 dark:text-purple-400">
                            Browse when available
                        </a>
                    </div>
                    @endif
                </div>
            </section>

            <!-- FOOTER NOTE -->
            <footer class="fade-up fade-up-4 pb-6 flex items-center justify-between">
                <p class="text-xs text-gray-400 dark:text-gray-600">
                    Logged in as <span class="font-semibold text-gray-500 dark:text-gray-500">{{ Auth::user()->email }}</span>
                </p>
                <p class="text-xs text-gray-300 dark:text-gray-700">Wandr &copy; {{ date('Y') }}</p>
            </footer>

        </div>
    </main>
</div>

<script>
    function toggleDarkMode() {
        const html = document.documentElement;
        html.classList.toggle('dark');
        document.getElementById('sunIcon').classList.toggle('hidden');
        document.getElementById('moonIcon').classList.toggle('hidden');
        localStorage.setItem('darkMode', html.classList.contains('dark'));
    }

    document.addEventListener('DOMContentLoaded', () => {
        const saved = localStorage.getItem('darkMode');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const isDark = saved !== null ? saved === 'true' : prefersDark;

        if (isDark) {
            document.documentElement.classList.add('dark');
            document.getElementById('sunIcon').classList.add('hidden');
            document.getElementById('moonIcon').classList.remove('hidden');
        }
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (localStorage.getItem('darkMode') === null) {
            document.documentElement.classList.toggle('dark', e.matches);
            document.getElementById('sunIcon').classList.toggle('hidden', e.matches);
            document.getElementById('moonIcon').classList.toggle('hidden', !e.matches);
        }
    });
</script>
</body>
</html>