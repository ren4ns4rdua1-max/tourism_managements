<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management | Admin Panel</title>
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
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        }
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .modal-enter {
            animation: modalEnter 0.3s ease-out forwards;
        }
        
        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .table-row-hover {
            transition: all 0.2s ease;
        }

        .table-row-hover:hover {
            background-color: rgba(59, 130, 246, 0.05);
            transform: scale(1.01);
        }

        .dark .table-row-hover:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false, viewFeedbackModal: false, currentFeedback: null }" class="flex min-h-screen">

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
                                    <i class="fas fa-users mr-3 text-blue-500"></i>
                                    Users Management
                                    <span class="ml-3 text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold px-3 py-1 rounded-full">
                                        {{ $users->total() }} Users
                                    </span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-chart-line text-xs mr-2"></i>
                                    View and manage system users • Last updated: {{ now()->format('M d, Y') }}
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
                                       class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 w-64 text-sm transition-all"
                                       placeholder="Search users..."
                                       onkeyup="searchUsers()">
                            </div>

                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>

                            <!-- Add User Button -->
                            <a href="{{ route('users.create') }}"
                                class="bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-700 hover:to-indigo-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3 group">
                                <i class="fas fa-plus-circle text-lg"></i>
                                Add User
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
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Users</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $users->total() }}</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
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
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Admins</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                                        {{ $users->where('role', 'admin')->count() }}
                                    </h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                    <i class="fas fa-crown text-red-600 dark:text-red-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-shield-alt text-red-500 mr-2"></i>
                                    <span class="text-gray-500 dark:text-gray-400">System administrators</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Managers</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                                        {{ $users->where('role', 'manager')->count() }}
                                    </h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                    <i class="fas fa-user-tie text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-briefcase text-green-500 mr-2"></i>
                                    <span class="text-gray-500 dark:text-gray-400">Content managers</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Regular Users</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                                        {{ $users->where('role', 'user')->count() }}
                                    </h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                    <i class="fas fa-user text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-user-circle text-purple-500 mr-2"></i>
                                    <span class="text-gray-500 dark:text-gray-400">Standard users</span>
                                </div>
                            </div>
                        </div>
                    </div>

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

                    <!-- Feedback Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <!-- Table Header -->
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">All Users</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Manage system users and their roles</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <select class="appearance-none bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl py-2 pl-4 pr-10 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-blue-500">
                                        <option>All Ratings</option>
                                        <option>5 Stars</option>
                                        <option>4 Stars</option>
                                        <option>3 Stars</option>
                                        <option>2 Stars</option>
                                        <option>1 Star</option>
                                    </select>
                                    <button class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <i class="fas fa-filter text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Table Content -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="usersTable">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-hashtag mr-2 text-gray-400"></i>
                                                ID
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-user mr-2 text-gray-400"></i>
                                                User
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                                Email
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-shield-alt mr-2 text-gray-400"></i>
                                                Role
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                                Date
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-cog mr-2 text-gray-400"></i>
                                                Actions
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($users as $user)
                                        <tr class="table-row-hover">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="text-sm font-bold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-lg">
                                                        #{{ $user->id }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-sm mr-3 shadow-md">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-700 dark:text-gray-300">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->role === 'admin')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                        <i class="fas fa-crown mr-1"></i> Admin
                                                    </span>
                                                @elseif($user->role === 'manager')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                        <i class="fas fa-user-tie mr-1"></i> Manager
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                        <i class="fas fa-user mr-1"></i> User
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white flex items-center">
                                                    <i class="fas fa-clock text-gray-400 mr-2 text-xs"></i>
                                                    {{ $user->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('users.edit', $user) }}"
                                                        class="px-3 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors font-semibold inline-flex items-center">
                                                        <i class="fas fa-edit mr-1.5"></i> Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="px-3 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors font-semibold inline-flex items-center">
                                                            <i class="fas fa-trash-alt mr-1.5"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                        <i class="fas fa-users text-gray-400 text-2xl"></i>
                                                    </div>
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No users found</h3>
                                                    <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by adding your first user</p>
                                                    <a href="{{ route('users.create') }}"
                                                       class="bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-700 hover:to-indigo-600 text-white font-semibold py-2 px-4 rounded-lg">
                                                        <i class="fas fa-plus-circle mr-2"></i> Add User
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($users->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    Showing <span class="font-semibold">{{ $users->firstItem() }}</span> to
                                    <span class="font-semibold">{{ $users->lastItem() }}</span> of
                                    <span class="font-semibold">{{ $users->total() }}</span> users
                                </p>
                                <div class="flex space-x-2">
                                    @if($users->onFirstPage())
                                    <button disabled class="px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-400 text-sm">
                                        <i class="fas fa-chevron-left mr-2"></i> Previous
                                    </button>
                                    @else
                                    <a href="{{ $users->previousPageUrl() }}" class="px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 text-sm">
                                        <i class="fas fa-chevron-left mr-2"></i> Previous
                                    </a>
                                    @endif

                                    @if($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-500 text-white rounded-xl text-sm shadow-sm hover:shadow">
                                        Next <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                    @else
                                    <button disabled class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-400 rounded-xl text-sm">
                                        Next <i class="fas fa-chevron-right ml-2"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- View Feedback Modal -->
    <div x-show="viewFeedbackModal"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="viewFeedbackModal = false">
        
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden modal-enter"
             x-show="viewFeedbackModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white font-bold text-xl">Feedback Details</h3>
                        <p class="text-blue-100 text-sm mt-1">Complete customer feedback information</p>
                    </div>
                    <button @click="viewFeedbackModal = false" class="text-white hover:text-blue-200 text-2xl">
                        &times;
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-5" x-show="currentFeedback">
                <!-- Customer Info -->
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <div class="flex items-center">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-xl mr-4 shadow-md">
                            <span x-text="currentFeedback && currentFeedback.user ? currentFeedback.user.name.charAt(0) : ''"></span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white" x-text="currentFeedback && currentFeedback.user ? currentFeedback.user.name : ''"></h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                <i class="fas fa-envelope text-xs mr-2"></i>
                                <span x-text="currentFeedback && currentFeedback.user ? currentFeedback.user.email : ''"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">Rating</label>
                    <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-4">
                        <div class="flex mr-3">
                            <template x-for="i in 5" :key="i">
                                <svg class="w-8 h-8" :class="currentFeedback && i <= currentFeedback.rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </template>
                        </div>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white" x-text="currentFeedback ? currentFeedback.rating + '/5' : ''"></span>
                    </div>
                </div>

                <!-- Feedback Text -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">Feedback Message</label>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed" x-text="currentFeedback ? currentFeedback.feedback_text : ''"></p>
                    </div>
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">Submitted Date</label>
                    <div class="flex items-center text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <i class="fas fa-calendar-alt mr-3 text-lg"></i>
                        <span x-text="currentFeedback && currentFeedback.created_at ? new Date(currentFeedback.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : ''"></span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-5 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                    <button type="button" @click="viewFeedbackModal = false"
                            class="px-6 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium rounded-xl transition-colors">
                        Close
                    </button>
                </div>
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

        // Search functionality
        function searchFeedback() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('feedbackTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        const textValue = cell.textContent || cell.innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        }

        // Close modal on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modal = document.querySelector('[x-data]');
                if (modal) {
                    Alpine.store('viewFeedbackModal', false);
                }
            }
        });
    </script>
</body>
</html>