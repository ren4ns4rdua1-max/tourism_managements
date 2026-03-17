@php
    use App\Models\TourPackage;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Package Management | Tourism Management</title>
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
                            50: '#eff6ff', 100: '#dbeafe',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'bounce-in': 'bounceIn 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        bounceIn: { '0%': { transform: 'scale(0.9)', opacity: '0' }, '70%': { transform: 'scale(1.05)' }, '100%': { transform: 'scale(1)', opacity: '1' } }
                    }
                }
            }
        }
    </script>
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -15px rgba(0,0,0,0.15); }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .tour-image-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .dark .tour-image-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }
        .slots-bar {
            background: linear-gradient(to right, #10b981 var(--filled), #e5e7eb var(--empty));
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        @include('layouts.sidebar-admin')

        <div class="flex-1 flex flex-col overflow-hidden lg:pl-64">
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center pl-12 lg:pl-0">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                <i class="fas fa-suitcase text-indigo-500"></i>
                                Tour Package Management
                                <span class="text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-bold px-3 py-1 rounded-full">
                                    {{ $tourPackages->count() }} Packages
                                </span>
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5 flex items-center gap-1.5">
                                <i class="fas fa-map text-xs"></i>
                                Manage tour packages and availability
                            </p>
                        </div>
                        <a href="{{ route('tour-packages.create') }}"
                           class="flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group">
                            <i class="fas fa-plus-circle"></i>
                            Add Package
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto space-y-6">
                    @if(session('success'))
                    <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 border-l-4 border-emerald-500 rounded-xl p-5 shadow-sm animate-fade-in">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-800/50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-emerald-800 dark:text-emerald-300">Success!</h3>
                                <p class="text-emerald-700 dark:text-emerald-400 text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 border-l-4 border-red-500 rounded-xl p-5 shadow-sm animate-fade-in">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800/50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-red-800 dark:text-red-300 mb-1">Please correct the following errors:</h3>
                                <ul class="list-disc list-inside text-red-700 dark:text-red-400 text-sm space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Total Packages</p>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $tourPackages->count() }}</h3>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-suitcase text-indigo-600 dark:text-indigo-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Active</p>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $tourPackages->where('status', 'active')->count() }}</h3>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Total Destinations</p>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $tourPackages->sum(fn($p) => $p->destinations->count()) }}</h3>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marked-alt text-blue-600 dark:text-blue-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Available Slots</p>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $tourPackages->sum(fn($p) => $p->remaining_slots) }}</h3>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-calendar-check text-green-600 dark:text-green-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">All Tour Packages</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Manage your tour packages</p>
                        </div>
                    </div>

                    @if($tourPackages->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($tourPackages as $index => $tourPackage)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700 animate-fade-in" style="animation-delay: {{ $index * 0.05 }}s">
                            <div class="relative h-44 tour-image-bg overflow-hidden">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-20 h-20 rounded-2xl bg-white/30 backdrop-blur-sm flex items-center justify-center shadow-lg border border-white/40">
                                        <i class="fas fa-suitcase text-3xl text-white drop-shadow-md"></i>
                                    </div>
                                </div>
                                <div class="absolute top-3 left-3">
                                    <div class="bg-white/90 dark:bg-gray-900/80 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                                        <i class="fas fa-calendar-days text-xs"></i>
                                        <span class="text-xs font-bold text-gray-700 dark:text-gray-200">{{ $tourPackage->duration_days }} days</span>
                                    </div>
                                </div>
                                <div class="absolute top-3 right-3">
                                    @if($tourPackage->status === 'active')
                                    <span class="flex items-center gap-1 px-2.5 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-sm">
                                        <i class="fas fa-circle text-[8px]"></i> Active
                                    </span>
                                    @else
                                    <span class="flex items-center gap-1 px-2.5 py-1 bg-gray-500 text-white text-xs font-bold rounded-full shadow-sm">
                                        <i class="fas fa-circle text-[8px]"></i> Inactive
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 truncate">{{ $tourPackage->name }}</h3>
                                <div class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400 text-sm mb-3">
                                    <i class="fas fa-map-marker-alt text-indigo-400 flex-shrink-0"></i>
                                    <span>{{ $tourPackage->destinations->pluck('name')->implode(', ') }}</span>
                                </div>
                                @if($tourPackage->description)
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    {{ Str::limit($tourPackage->description, 90) }}
                                </p>
                                @endif
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($tourPackage->price, 2) }}</div>
                                        @if($tourPackage->guide)
                                        <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-user-tie text-indigo-400"></i>
                                            {{ $tourPackage->guide->name }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Available Slots</span>
                                        <span class="ml-auto text-xs font-bold text-gray-900 dark:text-white">{{ $tourPackage->remaining_slots }} / {{ $tourPackage->available_slots }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="slots-bar h-2 rounded-full" style="--filled: {{ ($tourPackage->remaining_slots / max(1, $tourPackage->available_slots)) * 100 }}%;"></div>
                                    </div>
                                </div>
<div class="grid grid-cols-5 gap-2">
                                    <a href="{{ route('bookings.create', ['tour_package_id' => $tourPackage->id]) }}" class="flex flex-col items-center gap-1 py-2.5 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 rounded-xl transition-colors text-xs font-semibold">
                                        <i class="fas fa-calendar-check"></i> Book
                                    </a>
                                    <a href="{{ route('tour-package.show', $tourPackage) }}" class="flex flex-col items-center gap-1 py-2.5 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-xl transition-colors text-xs font-semibold">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('tour-package.edit', $tourPackage) }}" class="flex flex-col items-center gap-1 py-2.5 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/40 text-amber-600 dark:text-amber-400 rounded-xl transition-colors text-xs font-semibold">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('tour-package.destroy', $tourPackage) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($tourPackage->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex flex-col items-center gap-1 py-2.5 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 rounded-xl transition-colors text-xs font-semibold">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-sm border border-gray-100 dark:border-gray-700 animate-bounce-in">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-800/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-suitcase text-indigo-500 dark:text-indigo-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Tour Packages</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-8">Start creating tour packages for your customers!</p>
                            <a href="{{ route('tour-packages.create') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                                <i class="fas fa-plus-circle text-lg"></i>
                                Create First Package
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

