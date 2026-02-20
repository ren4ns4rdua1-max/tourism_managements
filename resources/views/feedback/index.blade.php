@php
    use App\Models\Gallery;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | Image Management</title>
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
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                        },
                        violet: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
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
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
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
        
        .star-rating {
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }
        
        .star-filled {
            color: #fbbf24;
            fill: #fbbf24;
        }
        
        .star-empty {
            color: #e2e8f0;
            fill: #e2e8f0;
        }
        
        .modal-enter {
            animation: modalEnter 0.3s ease-out forwards;
        }
        
        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: translate(-50%, -48%) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        
        @if(auth()->user()->role === 'admin')
            @include('layouts.sidebar-admin')
        @else
            @include('layouts.sidebar-manager')
        @endif

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
                                    Customer Feedback
                                    <span class="ml-3 text-xs bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 font-bold px-3 py-1 rounded-full">INSIGHTS</span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-comments text-xs mr-2"></i>
                                    {{ $feedbacks->total() }} feedback entries • Last updated: {{ now()->format('M d, Y') }}
                                </p>
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
                                       id="searchInput"
                                       class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 w-64 text-sm transition-all"
                                       placeholder="Search feedback...">
                            </div>
                            
                            <!-- Filter Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <i class="fas fa-filter text-lg"></i>
                                </button>
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition
                                     class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50"
                                     style="display: none;">
                                    <a href="{{ route('feedback.index') }}" 
                                       class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-list-ul mr-2 w-4"></i> All Feedback
                                    </a>
                                    <a href="{{ route('feedback.index', ['rating' => 5]) }}" 
                                       class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-star mr-2 w-4 text-yellow-500"></i> 5 Star Only
                                    </a>
                                    <a href="{{ route('feedback.index', ['rating' => 4]) }}" 
                                       class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-star mr-2 w-4 text-yellow-500"></i> 4 Star & Above
                                    </a>
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                    <a href="{{ route('feedback.index', ['sort' => 'recent']) }}" 
                                       class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-clock mr-2 w-4"></i> Most Recent
                                    </a>
                                    <a href="{{ route('feedback.index', ['sort' => 'oldest']) }}" 
                                       class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-calendar mr-2 w-4"></i> Oldest First
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <!-- Add Feedback Button -->
                            <a href="{{ route('feedback.create') }}"
                                class="bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3 group">
                                <i class="fas fa-plus-circle text-lg"></i>
                                Add Feedback
                                <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto">
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Feedback</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $feedbacks->total() }}</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                                    <i class="fas fa-comments text-violet-600 dark:text-violet-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-arrow-up text-green-500 mr-2"></i>
                                    <span class="text-green-600 dark:text-green-400 font-semibold">+12%</span>
                                    <span class="text-gray-500 dark:text-gray-400 ml-2">from last month</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Average Rating</p>
                                    <div class="flex items-end">
                                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($feedbacks->avg('rating') ?? 0, 1) }}</h3>
                                        <span class="text-gray-500 dark:text-gray-400 ml-1 text-lg">/5</span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                                    <i class="fas fa-star text-yellow-600 dark:text-yellow-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center space-x-1">
                                    @php $avgRating = $feedbacks->avg('rating') ?? 0; @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Response Rate</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">94%</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: 94%"></div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Excellent response rate</p>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">This Month</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $feedbacks->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <i class="fas fa-calendar text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-xs text-gray-500 dark:text-gray-400">↑ 8% from last month</span>
                            </div>
                        </div>
                    </div>

                    <!-- Alerts Section -->
                    @if(session('success') || $errors->any())
                    <div class="mb-8">
                        @if(session('success'))
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-800/20 border-l-4 border-green-500 rounded-xl p-5 shadow-lg animate-fade-in">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800/50 flex items-center justify-center mr-4">
                                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-green-800 dark:text-green-300 text-lg">Success!</h3>
                                    <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
                                </div>
                                <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 dark:text-green-400 hover:text-green-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-lg animate-fade-in mt-4">
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
                                <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 dark:text-red-400 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Feedback Header -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Feedback Collection</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">View and manage customer feedback and ratings</p>
                        </div>
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            <select id="ratingFilter" class="appearance-none bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 pl-4 pr-10 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-violet-500">
                                <option value="all">All Ratings</option>
                                <option value="5">5 Stars Only</option>
                                <option value="4">4 Stars & Up</option>
                                <option value="3">3 Stars & Up</option>
                            </select>
                            <button class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-download text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Feedback Grid/Table -->
                    @if($feedbacks->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800/50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            <div class="flex items-center space-x-1 cursor-pointer hover:text-gray-700 dark:hover:text-gray-300">
                                                <span>Customer</span>
                                                <i class="fas fa-sort text-xs"></i>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Feedback
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Rating
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($feedbacks as $index => $feedback)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group animate-fade-in" 
                                        style="animation-delay: {{ $index * 0.03 }}s">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 
                                                                flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                                        {{ substr($feedback->user->name ?? 'U', 0, 2) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $feedback->user->name ?? 'Unknown User' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        ID: #{{ $feedback->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs line-clamp-2">
                                                {{ $feedback->feedback_text }}
                                            </div>
                                            @if(strlen($feedback->feedback_text) > 100)
                                                <button onclick="viewFeedback({{ $feedback->id }})" 
                                                        class="text-xs text-violet-600 hover:text-violet-700 mt-1 font-medium">
                                                    Read more
                                                </button>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($feedback->rating)
                                                <div class="flex flex-col">
                                                    <div class="star-rating">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        {{ $feedback->rating }}/5
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400 dark:text-gray-500">No rating</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $feedback->created_at->format('M d, Y') }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $feedback->created_at->format('h:i A') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button onclick="viewFeedback({{ $feedback->id }})"
                                                        class="p-2 text-gray-600 hover:text-violet-600 dark:text-gray-400 
                                                               dark:hover:text-violet-400 rounded-lg hover:bg-gray-100 
                                                               dark:hover:bg-gray-700 transition-colors"
                                                        title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                @if(auth()->id() === $feedback->user_id || auth()->user()->isAdmin())
                                                    <form action="{{ route('feedback.destroy', $feedback) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Are you sure you want to delete this feedback?');"
                                                          class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="p-2 text-gray-600 hover:text-red-600 dark:text-gray-400 
                                                                       dark:hover:text-red-400 rounded-lg hover:bg-gray-100 
                                                                       dark:hover:bg-gray-700 transition-colors"
                                                                title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($feedbacks->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    Showing {{ $feedbacks->firstItem() }} to {{ $feedbacks->lastItem() }} of {{ $feedbacks->total() }} feedback entries
                                </p>
                                <div class="flex space-x-2">
                                    @if($feedbacks->onFirstPage())
                                    <button disabled class="px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-400 text-sm">
                                        <i class="fas fa-chevron-left mr-2"></i> Previous
                                    </button>
                                    @else
                                    <a href="{{ $feedbacks->previousPageUrl() }}" class="px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 text-sm">
                                        <i class="fas fa-chevron-left mr-2"></i> Previous
                                    </a>
                                    @endif
                                    
                                    @if($feedbacks->hasMorePages())
                                    <a href="{{ $feedbacks->nextPageUrl() }}" class="px-4 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 text-white rounded-xl text-sm shadow-sm hover:shadow">
                                        Next <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                    @else
                                    <button disabled class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-400 rounded-xl text-sm">
                                        Next <i class="fas fa-chevron-right ml-2"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-lg border border-gray-100 dark:border-gray-700 animate-bounce-in">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-violet-100 to-purple-100 dark:from-violet-900/30 dark:to-purple-800/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-comments text-violet-500 dark:text-violet-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Feedback Yet</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-8">Be the first to share your experience and help us improve!</p>
                            <a href="{{ route('feedback.create') }}"
                                class="bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-3">
                                <i class="fas fa-plus-circle text-lg"></i>
                                Add Your Feedback
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- View Feedback Modal -->
    <div id="viewFeedbackModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden modal-enter">
            <div class="bg-gradient-to-r from-violet-600 via-purple-600 to-fuchsia-600 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white font-bold text-xl" id="modalTitle">Feedback Details</h3>
                        <p class="text-purple-100 text-sm mt-1" id="modalSubtitle">View complete feedback information</p>
                    </div>
                    <button onclick="closeViewModal()" class="text-white hover:text-purple-200 text-2xl">
                        &times;
                    </button>
                </div>
            </div>
            <div class="p-6" id="modalContent">
                <!-- Dynamic content will be loaded here -->
            </div>
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

        // View feedback details
        function viewFeedback(id) {
            // This would typically fetch data via AJAX
            // For now, show modal with placeholder
            const modal = document.getElementById('viewFeedbackModal');
            const content = document.getElementById('modalContent');
            
            // In a real implementation, you'd fetch feedback data here
            content.innerHTML = `
                <div class="space-y-6">
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 
                                    flex items-center justify-center text-white font-bold text-lg mr-4">
                            ${id}
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Customer #${id}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Feedback ID: #FB-${id}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Feedback Content</label>
                        <p class="text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl">
                            Loading feedback details...
                        </p>
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeViewModal() {
            document.getElementById('viewFeedbackModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', debounce(function(e) {
                const searchTerm = e.target.value;
                // Implement search logic
                console.log('Searching:', searchTerm);
            }, 500));
        }

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Rating filter
        const ratingFilter = document.getElementById('ratingFilter');
        if (ratingFilter) {
            ratingFilter.addEventListener('change', function() {
                const value = this.value;
                if (value === 'all') {
                    window.location.href = "{{ route('feedback.index') }}";
                } else {
                    window.location.href = "{{ route('feedback.index') }}?rating=" + value;
                }
            });
        }

        // Close modals on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeViewModal();
            }
        });

        // Close modal on backdrop click
        document.getElementById('viewFeedbackModal')?.addEventListener('click', (e) => {
            if (e.target.id === 'viewFeedbackModal') closeViewModal();
        });
    </script>
</body>
</html>                                 