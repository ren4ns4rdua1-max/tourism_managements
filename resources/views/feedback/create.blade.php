@php
    use App\Models\Gallery;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Feedback | Customer Feedback System</title>
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
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.4s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'shimmer': 'shimmer 2s linear infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(-20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.8)', opacity: '0' },
                            '50%': { transform: 'scale(1.05)' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-1000px 0' },
                            '100%': { backgroundPosition: '1000px 0' },
                        },
                        glow: {
                            '0%': { boxShadow: '0 0 20px rgba(139, 92, 246, 0.3)' },
                            '100%': { boxShadow: '0 0 30px rgba(139, 92, 246, 0.6)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
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
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #8b5cf6, #7c3aed);
            border-radius: 10px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #7c3aed, #6d28d9);
        }
        
        .star-rating {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .star-input {
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .star-input:hover {
            transform: scale(1.25) rotate(15deg);
            filter: drop-shadow(0 4px 8px rgba(251, 191, 36, 0.4));
        }
        
        .star-input:active {
            transform: scale(1.1) rotate(0deg);
        }
        
        .star-filled {
            color: #fbbf24;
            fill: #fbbf24;
            animation: starPulse 0.5s ease-out;
        }
        
        @keyframes starPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }
        
        .star-empty {
            color: #e2e8f0;
            fill: #e2e8f0;
        }
        
        .gradient-border {
            position: relative;
            background: white;
            border-radius: 1rem;
        }
        
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 1rem;
            padding: 2px;
            background: linear-gradient(135deg, #8b5cf6, #ec4899, #fbbf24);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .gradient-border:focus-within::before {
            opacity: 1;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .dark .glass-effect {
            background: rgba(31, 41, 55, 0.9);
        }
        
        .shimmer-text {
            background: linear-gradient(90deg, 
                #8b5cf6 0%, 
                #ec4899 25%, 
                #fbbf24 50%, 
                #ec4899 75%, 
                #8b5cf6 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
        }
        
        .input-focus-effect {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .input-focus-effect:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.2);
        }
        
        .floating-label {
            position: absolute;
            left: 3rem;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s;
            pointer-events: none;
            color: #9ca3af;
        }
        
        .has-content .floating-label,
        input:focus ~ .floating-label,
        select:focus ~ .floating-label,
        textarea:focus ~ .floating-label {
            top: -0.5rem;
            left: 1rem;
            font-size: 0.75rem;
            color: #8b5cf6;
            background: white;
            padding: 0 0.5rem;
        }
        
        .dark .has-content .floating-label,
        .dark input:focus ~ .floating-label,
        .dark select:focus ~ .floating-label,
        .dark textarea:focus ~ .floating-label {
            background: #1f2937;
        }
        
        .progress-bar {
            height: 4px;
            background: linear-gradient(90deg, #8b5cf6, #ec4899, #fbbf24);
            background-size: 200% 100%;
            animation: shimmer 2s linear infinite;
        }
        
        .tooltip {
            position: relative;
        }
        
        .tooltip::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-8px);
            padding: 0.5rem 1rem;
            background: #1f2937;
            color: white;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .tooltip:hover::before {
            opacity: 1;
            transform: translateX(-50%) translateY(-4px);
        }
        
        .character-counter {
            font-size: 0.75rem;
            transition: color 0.3s;
        }
        
        .character-counter.warning {
            color: #f59e0b;
        }
        
        .character-counter.danger {
            color: #ef4444;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ 
        sidebarOpen: false, 
        rating: {{ old('rating', 0) }},
        feedbackLength: {{ strlen(old('feedback_text', '')) }},
        maxLength: 500
    }" class="flex min-h-screen">
        
        @if(auth()->user()->role === 'admin')
            @include('layouts.sidebar-admin')
        @else
            @include('layouts.sidebar-manager')
        @endif

        <!-- Mobile Menu Button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="p-3 rounded-xl bg-white dark:bg-gray-800 shadow-xl text-gray-600 dark:text-gray-300 hover:scale-110 transition-transform">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header with Gradient -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-violet-500/5 via-purple-500/5 to-fuchsia-500/5"></div>
                <div class="px-6 py-4 relative z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center pl-12 lg:pl-0">
                            <div class="animate-slide-in">
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <a href="{{ route('feedback.index') }}" 
                                       class="text-violet-600 hover:text-violet-700 mr-3 hover:scale-110 transition-transform inline-block">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    <span class="shimmer-text">Add Customer Feedback</span>
                                    <span class="ml-3 text-xs bg-gradient-to-r from-violet-100 to-purple-100 dark:from-violet-900/30 dark:to-purple-900/30 text-violet-700 dark:text-violet-300 font-bold px-3 py-1 rounded-full animate-pulse-slow">NEW</span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center animate-fade-in">
                                    <i class="fas fa-plus-circle text-xs mr-2 text-violet-500"></i>
                                    Create a new feedback entry for a customer
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 animate-slide-in" style="animation-delay: 0.1s">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gradient-to-br hover:from-violet-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 rounded-xl transition-all duration-300 hover:scale-110 tooltip"
                                data-tooltip="Toggle Dark Mode">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            
                            <!-- Notifications -->
                            <button class="relative p-2.5 text-gray-500 dark:text-gray-400 hover:text-violet-600 dark:hover:text-violet-400 hover:bg-gradient-to-br hover:from-violet-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 rounded-xl transition-all duration-300 hover:scale-110 tooltip"
                                    data-tooltip="Notifications">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></span>
                            </button>
                            
                            <!-- Back to Feedback List -->
                            <a href="{{ route('feedback.index') }}"
                                class="bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 hover:from-gray-200 hover:to-gray-300 dark:hover:from-gray-600 dark:hover:to-gray-500 text-gray-700 dark:text-gray-200 font-semibold py-2.5 px-5 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 flex items-center gap-2 group hover:scale-105">
                                <i class="fas fa-list text-base"></i>
                                <span class="hidden md:inline">View All</span>
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Progress Bar -->
                <div class="progress-bar"></div>
            </header>

            <!-- Main Content Area with Background Pattern -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-br from-gray-50 via-violet-50/20 to-purple-50/20 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 relative">
                <!-- Decorative Elements -->
                <div class="absolute top-10 right-10 w-72 h-72 bg-gradient-to-br from-violet-300/20 to-purple-300/20 rounded-full blur-3xl animate-float"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-gradient-to-br from-fuchsia-300/20 to-pink-300/20 rounded-full blur-3xl animate-float" style="animation-delay: 1s"></div>
                
                <div class="max-w-4xl mx-auto relative z-10">
                    
                    <!-- Alerts Section -->
                    @if(session('success') || $errors->any())
                    <div class="mb-8">
                        @if(session('success'))
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-800/20 border-l-4 border-green-500 rounded-xl p-5 shadow-xl animate-bounce-in backdrop-blur-sm">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center mr-4 shadow-lg animate-pulse">
                                    <i class="fas fa-check-circle text-white text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-green-800 dark:text-green-300 text-lg">Success!</h3>
                                    <p class="text-green-700 dark:text-green-400 mt-1">{{ session('success') }}</p>
                                </div>
                                <button onclick="this.parentElement.parentElement.remove()" 
                                        class="text-green-600 dark:text-green-400 hover:text-green-800 hover:scale-110 transition-transform p-2">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-xl animate-bounce-in mt-4 backdrop-blur-sm">
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center mr-4 mt-1 shadow-lg animate-pulse">
                                    <i class="fas fa-exclamation-circle text-white text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-red-800 dark:text-red-300 text-lg mb-2">Please correct the following errors:</h3>
                                    <ul class="space-y-2">
                                        @foreach($errors->all() as $error)
                                            <li class="flex items-start text-red-700 dark:text-red-400">
                                                <i class="fas fa-circle text-xs mr-2 mt-1.5"></i>
                                                <span>{{ $error }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button onclick="this.parentElement.parentElement.remove()" 
                                        class="text-red-600 dark:text-red-400 hover:text-red-800 hover:scale-110 transition-transform p-2">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Form Card with Glass Effect -->
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden animate-slide-up">
                        <!-- Card Header with Animated Gradient -->
                        <div class="bg-gradient-to-r from-violet-600 via-purple-600 to-fuchsia-600 px-8 py-6 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></div>
                            <div class="flex items-center relative z-10">
                                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mr-4 shadow-lg animate-float">
                                    <i class="fas fa-comment-dots text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-white font-bold text-2xl flex items-center">
                                        Feedback Information
                                        <span class="ml-3 text-xs bg-white/20 px-3 py-1 rounded-full">Step 1 of 1</span>
                                    </h2>
                                    <p class="text-purple-100 text-sm mt-1 flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Fill in the customer feedback details below
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('feedback.store') }}" class="p-8 space-y-8">
                            @csrf

                            <!-- Customer Selection -->
                            <div class="animate-fade-in" style="animation-delay: 0.1s">
                                <label for="user_id" class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center mr-3 shadow-md">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                    Select Customer
                                    <span class="text-red-500 ml-1 text-lg">*</span>
                                    <span class="ml-auto text-xs font-normal text-gray-500 dark:text-gray-400">Required field</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                        <i class="fas fa-users text-gray-400 text-lg"></i>
                                    </div>
                                    <select id="user_id" name="user_id"
                                            class="pl-14 pr-4 block w-full border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-4 focus:ring-violet-500/20 dark:focus:ring-violet-500/20 rounded-xl shadow-sm text-base py-4 transition-all input-focus-effect hover:border-violet-400">
                                        <option value="">Choose a customer...</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user_id')
                                    <p class="mt-3 text-sm text-red-600 dark:text-red-400 flex items-center bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg animate-fade-in">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Feedback Text -->
                            <div class="animate-fade-in" style="animation-delay: 0.2s">
                                <label for="feedback_text" class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center mr-3 shadow-md">
                                        <i class="fas fa-comment-alt text-white text-sm"></i>
                                    </div>
                                    Feedback Message
                                    <span class="text-red-500 ml-1 text-lg">*</span>
                                    <span class="ml-auto text-xs font-normal" 
                                          :class="feedbackLength > maxLength ? 'text-red-500' : feedbackLength > maxLength * 0.9 ? 'text-yellow-500' : 'text-gray-500 dark:text-gray-400'">
                                        <span x-text="feedbackLength"></span> / <span x-text="maxLength"></span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <textarea id="feedback_text" name="feedback_text"
                                              x-model="feedbackLength"
                                              @input="feedbackLength = $event.target.value.length"
                                              :maxlength="maxLength"
                                              class="block w-full border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-4 focus:ring-violet-500/20 dark:focus:ring-violet-500/20 rounded-xl shadow-sm text-base py-4 px-4 transition-all input-focus-effect hover:border-violet-400 resize-none"
                                              rows="6"
                                              placeholder="Share detailed feedback about the customer's experience...">{{ old('feedback_text') }}</textarea>
                                    <div class="absolute bottom-3 right-3">
                                        <div class="bg-gray-100 dark:bg-gray-600 px-3 py-1 rounded-lg text-xs font-medium"
                                             :class="feedbackLength > maxLength * 0.9 ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-300'">
                                            <i class="fas fa-keyboard mr-1"></i>
                                            <span x-text="maxLength - feedbackLength"></span> chars left
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 flex items-start space-x-2 text-sm text-gray-500 dark:text-gray-400 bg-blue-50 dark:bg-blue-900/20 px-4 py-3 rounded-lg">
                                    <i class="fas fa-lightbulb text-blue-500 mt-0.5"></i>
                                    <p>
                                        <strong class="text-blue-700 dark:text-blue-400">Pro Tip:</strong> 
                                        Be specific and constructive. Include what went well and areas for improvement.
                                    </p>
                                </div>
                                @error('feedback_text')
                                    <p class="mt-3 text-sm text-red-600 dark:text-red-400 flex items-center bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg animate-fade-in">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Rating Selection -->
                            <div class="animate-fade-in" style="animation-delay: 0.3s">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center mr-3 shadow-md">
                                        <i class="fas fa-star text-white text-sm"></i>
                                    </div>
                                    Customer Rating
                                    <span class="text-red-500 ml-1 text-lg">*</span>
                                    <span class="ml-auto text-xs font-normal text-gray-500 dark:text-gray-400">Rate from 1-5 stars</span>
                                </label>
                                <div class="bg-gradient-to-br from-gray-50 to-violet-50/30 dark:from-gray-700/50 dark:to-violet-900/10 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-600 hover:border-violet-300 dark:hover:border-violet-500 transition-all">
                                    <div class="flex items-center justify-center space-x-4 mb-6">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer group relative">
                                                <input type="radio" 
                                                       name="rating" 
                                                       value="{{ $i }}"
                                                       x-model="rating"
                                                       class="sr-only"
                                                       {{ old('rating') == $i ? 'checked' : '' }}>
                                                <div class="flex flex-col items-center space-y-2">
                                                    <div class="relative">
                                                        <svg class="w-16 h-16 transition-all duration-300 star-input"
                                                             :class="rating >= {{ $i }} ? 'text-yellow-400 star-filled' : 'text-gray-300 dark:text-gray-600 group-hover:text-yellow-200 dark:group-hover:text-yellow-300'"
                                                             fill="currentColor" 
                                                             viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                        <div x-show="rating >= {{ $i }}" 
                                                             class="absolute inset-0 flex items-center justify-center"
                                                             x-transition>
                                                            <div class="w-20 h-20 bg-yellow-400/20 rounded-full blur-xl"></div>
                                                        </div>
                                                    </div>
                                                    <span class="text-xs font-bold px-3 py-1 rounded-full transition-all"
                                                          :class="rating >= {{ $i }} ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400 group-hover:text-violet-600 dark:group-hover:text-violet-400'">
                                                        {{ $i }}★
                                                    </span>
                                                </div>
                                            </label>
                                        @endfor
                                    </div>
                                    
                                    <div class="text-center space-y-2">
                                        <div x-show="rating === 0" class="animate-fade-in">
                                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center">
                                                <i class="fas fa-hand-pointer mr-2 text-violet-500 animate-pulse"></i>
                                                Click on the stars above to select a rating
                                            </p>
                                        </div>
                                        
                                        <div x-show="rating > 0" class="space-y-2 animate-bounce-in" x-cloak>
                                            <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-violet-500 to-purple-600 text-white rounded-xl shadow-lg">
                                                <i class="fas fa-check-circle mr-2 text-xl"></i>
                                                <span class="font-bold text-lg" x-text="rating + ' Star' + (rating > 1 ? 's' : '') + ' Selected'"></span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400" x-show="rating === 5">
                                                <i class="fas fa-trophy text-yellow-500 mr-1"></i>
                                                Excellent rating! Customer is very satisfied
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400" x-show="rating === 4">
                                                <i class="fas fa-thumbs-up text-green-500 mr-1"></i>
                                                Good rating! Customer had a positive experience
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400" x-show="rating === 3">
                                                <i class="fas fa-meh text-yellow-500 mr-1"></i>
                                                Average rating. Room for improvement
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400" x-show="rating <= 2">
                                                <i class="fas fa-exclamation-triangle text-red-500 mr-1"></i>
                                                Low rating. Consider follow-up action
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @error('rating')
                                    <p class="mt-3 text-sm text-red-600 dark:text-red-400 flex items-center bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg animate-fade-in">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between pt-8 border-t-2 border-gray-200 dark:border-gray-700 animate-fade-in" style="animation-delay: 0.4s">
                                <a href="{{ route('feedback.index') }}"
                                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 border-2 border-gray-300 dark:border-gray-500 rounded-xl font-bold text-sm text-gray-700 dark:text-gray-200 uppercase tracking-wider shadow-lg hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-gray-400/50 transition-all duration-300 group">
                                    <i class="fas fa-times mr-3 group-hover:-translate-x-1 transition-transform"></i>
                                    Cancel
                                </a>

                                <button type="submit"
                                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-violet-600 via-purple-600 to-fuchsia-600 hover:from-violet-700 hover:via-purple-700 hover:to-fuchsia-700 border-2 border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider shadow-xl hover:shadow-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-violet-500/50 transition-all duration-300 group relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>
                                    <i class="fas fa-save mr-3 relative z-10"></i>
                                    <span class="relative z-10">Add Feedback</span>
                                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform relative z-10"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Help Card -->
                    <div class="mt-8 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 border-2 border-blue-200 dark:border-blue-800 shadow-lg animate-slide-up backdrop-blur-sm" style="animation-delay: 0.5s">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center shadow-lg animate-float">
                                    <i class="fas fa-lightbulb text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-5 flex-1">
                                <h3 class="text-base font-bold text-blue-900 dark:text-blue-200 mb-3 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Tips for Adding Quality Feedback
                                </h3>
                                <ul class="space-y-3">
                                    <li class="flex items-start text-sm text-blue-800 dark:text-blue-300">
                                        <div class="w-6 h-6 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                                            <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                                        </div>
                                        <span><strong>Select carefully:</strong> Ensure you choose the correct customer from the dropdown menu</span>
                                    </li>
                                    <li class="flex items-start text-sm text-blue-800 dark:text-blue-300">
                                        <div class="w-6 h-6 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                                            <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                                        </div>
                                        <span><strong>Be specific:</strong> Provide detailed and constructive feedback with examples</span>
                                    </li>
                                    <li class="flex items-start text-sm text-blue-800 dark:text-blue-300">
                                        <div class="w-6 h-6 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                                            <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                                        </div>
                                        <span><strong>Rate honestly:</strong> Use the star rating to accurately reflect the customer's experience</span>
                                    </li>
                                    <li class="flex items-start text-sm text-blue-800 dark:text-blue-300">
                                        <div class="w-6 h-6 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                                            <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                                        </div>
                                        <span><strong>Stay professional:</strong> Maintain a respectful and professional tone throughout</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script>
        // Dark mode toggle with smooth transition
        function toggleDarkMode() {
            const html = document.documentElement;
            html.style.transition = 'background-color 0.3s ease';
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        }

        // Initialize dark mode
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }

        // Add floating animation delay variation
        document.addEventListener('DOMContentLoaded', function() {
            const floatingElements = document.querySelectorAll('.animate-float');
            floatingElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.5}s`;
            });
        });
    </script>
</body>
</html>