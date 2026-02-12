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
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false, addUserModal: false, editUserModal: false, currentUser: null }" class="flex min-h-screen">
        
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
                                    <i class="fas fa-users mr-3 text-violet-500"></i>
                                    Users Management
                                    <span class="ml-3 text-xs bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 font-bold px-3 py-1 rounded-full">
                                        {{ $users->total() }} Users
                                    </span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-user-cog text-xs mr-2"></i>
                                    Manage user accounts and permissions • Last updated: {{ now()->format('M d, Y') }}
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
                                       placeholder="Search users..."
                                       onkeyup="searchUsers()">
                            </div>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <!-- Add User Button -->
                            <button @click="addUserModal = true"
                                class="bg-gradient-to-r from-violet-600 to-purple-500 hover:from-violet-700 hover:to-purple-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3 group">
                                <i class="fas fa-user-plus text-lg"></i>
                                Add New User
                                <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                            </button>
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
                                <div class="w-12 h-12 rounded-xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                                    <i class="fas fa-users text-violet-600 dark:text-violet-400 text-xl"></i>
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
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Administrators</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $users->where('role', 'admin')->count() }}</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <i class="fas fa-user-shield text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-shield-alt text-blue-500 mr-2"></i>
                                    <span class="text-gray-500 dark:text-gray-400">Full access</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Managers</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $users->where('role', 'manager')->count() }}</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                    <i class="fas fa-user-tie text-amber-600 dark:text-amber-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-tasks text-amber-500 mr-2"></i>
                                    <span class="text-gray-500 dark:text-gray-400">Content management</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Regular Users</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $users->where('role', 'user')->count() }}</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                    <i class="fas fa-user text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-eye text-green-500 mr-2"></i>
                                    <span class="text-gray-500 dark:text-gray-400">View only</span>
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

                    <!-- Users Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <!-- Table Header -->
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">All Users</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Manage user accounts and roles</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <select class="appearance-none bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl py-2 pl-4 pr-10 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-violet-500">
                                        <option>All Roles</option>
                                        <option>Admin</option>
                                        <option>Manager</option>
                                        <option>User</option>
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
                                                <i class="fas fa-user-tag mr-2 text-gray-400"></i>
                                                Role
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                                Registered
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
                                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm mr-3 shadow-md">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">Active account</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white flex items-center">
                                                    <i class="fas fa-envelope text-gray-400 mr-2 text-xs"></i>
                                                    {{ $user->email }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->role === 'admin')
                                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 text-blue-800 dark:text-blue-300 border border-blue-300 dark:border-blue-700">
                                                        <i class="fas fa-user-shield mr-1.5"></i> Admin
                                                    </span>
                                                @elseif($user->role === 'manager')
                                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-amber-100 to-amber-200 dark:from-amber-900/30 dark:to-amber-800/30 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-700">
                                                        <i class="fas fa-user-tie mr-1.5"></i> Manager
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-green-100 to-green-200 dark:from-green-900/30 dark:to-green-800/30 text-green-800 dark:text-green-300 border border-green-300 dark:border-green-700">
                                                        <i class="fas fa-user mr-1.5"></i> User
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
                                                    <button @click="addUserModal = true"
                                                            class="bg-gradient-to-r from-violet-600 to-purple-500 hover:from-violet-700 hover:to-purple-600 text-white font-semibold py-2 px-4 rounded-lg">
                                                        <i class="fas fa-user-plus mr-2"></i> Add User
                                                    </button>
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
                                    <a href="{{ $users->nextPageUrl() }}" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-purple-500 text-white rounded-xl text-sm shadow-sm hover:shadow">
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

    <!-- Add User Modal -->
    <div x-show="addUserModal"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="addUserModal = false">
        
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden modal-enter"
             x-show="addUserModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-violet-600 via-purple-600 to-fuchsia-600 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white font-bold text-xl">Add New User</h3>
                        <p class="text-purple-100 text-sm mt-1">Create a new user account</p>
                    </div>
                    <button @click="addUserModal = false" class="text-white hover:text-purple-200 text-2xl">
                        &times;
                    </button>
                </div>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" name="name" required 
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" required 
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user-tag text-gray-400"></i>
                        </div>
                        <select name="role" required
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent appearance-none">
                            <option value="user">User - View only access</option>
                            <option value="manager">Manager - Content management</option>
                            <option value="admin">Admin - Full system access</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" required 
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Minimum 8 characters</p>
                </div>

                <div class="pt-5 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                    <button type="button" @click="addUserModal = false"
                            class="px-6 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-gradient-to-r from-violet-600 to-purple-500 hover:from-violet-700 hover:to-purple-600 text-white font-semibold px-8 py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-user-plus"></i>
                        Create User
                    </button>
                </div>
            </form>
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
        function searchUsers() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('usersTable');
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
                    Alpine.store('addUserModal', false);
                }
            }
        });
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>