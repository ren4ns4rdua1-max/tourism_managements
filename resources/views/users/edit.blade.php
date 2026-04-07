<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Admin Panel</title>
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
                                    <i class="fas fa-user-edit mr-3 text-blue-500"></i>
                                    Edit User: {{ $user->name }}
                                    <span class="ml-3 text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold px-3 py-1 rounded-full">
                                        {{ ucfirst($user->role) }} Account
                                    </span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-user-cog text-xs mr-2"></i>
                                    Update user details and permissions
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
                            
                            <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3">
                                <i class="fas fa-arrow-left"></i>
                                Back to Users
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-2xl mx-auto">
                    
                    <!-- Success/Error Alerts -->
                    @if(session('success'))
                    <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-6 rounded-2xl shadow-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-2xl mr-4"></i>
                            <div>
                                <h3 class="font-bold text-xl">Success!</h3>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="bg-gradient-to-r from-red-500 to-pink-600 text-white p-6 rounded-2xl shadow-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-2xl mr-4"></i>
                            <div>
                                <h3 class="font-bold text-xl">Please fix the errors below:</h3>
                                <ul class="mt-2 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li><i class="fas fa-circle mr-2 text-sm"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Form Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden card-hover">
                        
                        <!-- Card Header -->
                        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Update User Details</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Modify account information and role</p>
                                </div>
                                <div class="flex items-center space-x-3 text-sm">
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full font-semibold">
                                        ID: {{ $user->id }}
                                    </span>
                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-full font-semibold">
                                        Created: {{ $user->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('users.update', $user) }}" method="POST" class="p-8 space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- User Avatar/Info Preview -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-6 rounded-xl border-2 border-dashed border-blue-200 dark:border-blue-800">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                                           class="w-full pl-12 pr-4 py-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           placeholder="Enter full name">
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                           class="w-full pl-12 pr-4 py-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           placeholder="user@example.com">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user-tag text-gray-400"></i>
                                    </div>
                                    <select name="role" required
                                            class="w-full pl-12 pr-10 py-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User - View only access</option>
                                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager - Content management</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin - Full system access</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Optional Password Change -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-5 h-5 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-key text-white text-xs"></i>
                                    </div>
                                    <label class="text-lg font-bold text-gray-900 dark:text-white cursor-pointer select-none">
                                        <input type="checkbox" id="changePassword" class="mr-2">
                                        Change Password
                                    </label>
                                </div>
                                <div id="passwordFields" style="display: none;">
                                    <div class="space-y-4 pl-8">
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">New Password</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <i class="fas fa-lock text-gray-400"></i>
                                                </div>
                                                <input type="password" name="password" 
                                                       class="w-full pl-12 pr-4 py-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                                                       placeholder="Leave blank to keep current">
                                            </div>
                                            @error('password')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">Confirm Password</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <i class="fas fa-lock text-gray-400"></i>
                                                </div>
                                                <input type="password" name="password_confirmation" 
                                                       class="w-full pl-12 pr-4 py-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                                                       placeholder="Confirm new password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                <a href="{{ route('users.index') }}"
                                   class="order-2 sm:order-1 flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-center">
                                    <i class="fas fa-times mr-2"></i>Cancel
                                </a>
                                <button type="submit"
                                        class="order-1 sm:order-2 flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-save"></i>
                                    Update User
                                </button>
                            </div>
                        </form>
                    </div>
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

        // Password toggle
        document.getElementById('changePassword').addEventListener('change', function() {
            const fields = document.getElementById('passwordFields');
            if (this.checked) {
                fields.style.display = 'block';
            } else {
                fields.style.display = 'none';
                document.querySelector('input[name="password"]').value = '';
                document.querySelector('input[name="password_confirmation"]').value = '';
            }
        });
    </script>
</body>
</html>

