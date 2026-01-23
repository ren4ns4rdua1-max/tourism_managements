<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <button onclick="toggleDarkMode()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg id="darkModeIcon" class="h-5 w-5 text-gray-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg id="lightModeIcon" class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <div class="relative">
                    <button id="notificationBtn" class="p-2 rounded-lg hover:bg-gray-100 transition-colors relative">
                        <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-900">Notifications</h4>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <a href="#" class="flex items-start px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg">
                                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">New user registration</p>
                                    <p class="text-xs text-gray-500">2 minutes ago</p>
                                </div>
                            </a>
                            <a href="#" class="flex items-start px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                <div class="flex-shrink-0 bg-green-100 p-2 rounded-lg">
                                    <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">Order #7841 completed</p>
                                    <p class="text-xs text-gray-500">15 minutes ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="px-4 py-3 border-t border-gray-200">
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all notifications</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 overflow-hidden shadow-lg sm:rounded-2xl relative">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div class="mb-6 md:mb-0">
                                <h1 class="text-3xl md:text-4xl font-bold mb-3">
                                    Welcome back, {{ Auth::user()->name }}! 👋
                                </h1>
                                <p class="text-blue-100 opacity-95 text-lg">
                                    Here's what's happening with your account today.
                                </p>
                            </div>
                            <div>
                                <div class="inline-flex items-center bg-white/20 backdrop-blur-sm px-6 py-3 rounded-xl">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium">{{ now()->format('l, F j, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                <span class="text-sm">System is running smoothly</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                <span class="text-sm">Last updated: Today at {{ now()->format('g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @php
                    $stats = [
                        [
                            'title' => 'Total Users',
                            'value' => '2,847',
                            'change' => '+12.5%',
                            'changeType' => 'increase',
                            'icon' => 'users',
                            'color' => 'blue',
                            'trend' => 'up'
                        ],
                        [
                            'title' => 'Revenue',
                            'value' => '$24,580',
                            'change' => '+8.2%',
                            'changeType' => 'increase',
                            'icon' => 'currency-dollar',
                            'color' => 'green',
                            'trend' => 'up'
                        ],
                        [
                            'title' => 'Conversion Rate',
                            'value' => '3.24%',
                            'change' => '-0.5%',
                            'changeType' => 'decrease',
                            'icon' => 'trending-up',
                            'color' => 'purple',
                            'trend' => 'down'
                        ],
                        [
                            'title' => 'Active Sessions',
                            'value' => '1,249',
                            'change' => '+23.1%',
                            'changeType' => 'increase',
                            'icon' => 'eye',
                            'color' => 'orange',
                            'trend' => 'up'
                        ]
                    ];
                @endphp

                @foreach($stats as $stat)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-shrink-0 bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 p-3 rounded-xl">
                                @if($stat['icon'] === 'users')
                                <svg class="h-7 w-7 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.67 3.913a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                @elseif($stat['icon'] === 'currency-dollar')
                                <svg class="h-7 w-7 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @elseif($stat['icon'] === 'trending-up')
                                <svg class="h-7 w-7 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                @elseif($stat['icon'] === 'eye')
                                <svg class="h-7 w-7 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $stat['changeType'] === 'increase' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                    @if($stat['trend'] === 'up')
                                    <svg class="-ml-0.5 mr-1.5 h-2 w-2" fill="currentColor" viewBox="0 0 8 8">
                                        <path d="M2.5 0L4 1.5 5.5 0 5.5 2 8 2 8 4.5 6.5 6 5 4.5 3.5 6 2 4.5 2 2z" />
                                    </svg>
                                    @else
                                    <svg class="-ml-0.5 mr-1.5 h-2 w-2" fill="currentColor" viewBox="0 0 8 8">
                                        <path d="M5.5 8L4 6.5 2.5 8 2.5 6 0 6 0 3.5 1.5 2 3 3.5 4.5 2 6 3.5 6 6z" />
                                    </svg>
                                    @endif
                                    {{ $stat['change'] }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $stat['title'] }}</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stat['value'] }}</p>
                        </div>
                        <div class="mt-6">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <span>Compared to last month</span>
                                <div class="ml-auto">
                                    <button onclick="viewStatDetails('{{ $stat['title'] }}')" class="text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 hover:text-{{ $stat['color'] }}-800 dark:hover:text-{{ $stat['color'] }}-300 font-medium group-hover:underline">
                                        View details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Charts and Tables Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Revenue Chart -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Revenue Overview
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Monthly revenue performance</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button id="btn-7d" class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-200" onclick="changeTimeRange('7d')">
                                        Last 7 days
                                    </button>
                                    <button id="btn-30d" class="px-4 py-2 text-sm rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200" onclick="changeTimeRange('30d')">
                                        Last 30 days
                                    </button>
                                    <button id="btn-ytd" class="px-4 py-2 text-sm rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200" onclick="changeTimeRange('ytd')">
                                        Year to date
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <!-- Chart.js Revenue Chart -->
                            <div class="h-80 relative">
                                <canvas id="revenueChart" width="400" height="200"></canvas>
                            </div>
                            
                            <!-- Chart Summary -->
                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Revenue</p>
                                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">$24,580</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Avg. Order Value</p>
                                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">$1,245</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Growth Rate</p>
                                        <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1">+8.2%</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Target</p>
                                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">$30,000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 h-full flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Recent Activity
                                </h3>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Live</span>
                            </div>
                        </div>
                        <div class="flex-1 p-6 overflow-y-auto">
                            <div class="space-y-6">
                                @php
                                    $activities = [
                                        ['user' => 'John Doe', 'action' => 'signed up for premium', 'time' => '2 min ago', 'color' => 'blue', 'icon' => 'user-add'],
                                        ['user' => 'Sarah Smith', 'action' => 'upgraded to enterprise', 'time' => '15 min ago', 'color' => 'green', 'icon' => 'arrow-up'],
                                        ['user' => 'Michael Chen', 'action' => 'completed a project', 'time' => '1 hour ago', 'color' => 'purple', 'icon' => 'check-circle'],
                                        ['user' => 'Emma Wilson', 'action' => 'left a 5-star review', 'time' => '2 hours ago', 'color' => 'yellow', 'icon' => 'star'],
                                        ['user' => 'Alex Johnson', 'action' => 'renewed subscription', 'time' => '5 hours ago', 'color' => 'indigo', 'icon' => 'refresh'],
                                        ['user' => 'Lisa Brown', 'action' => 'downloaded report', 'time' => 'Yesterday', 'color' => 'pink', 'icon' => 'download'],
                                    ];
                                @endphp
                                
                                @foreach($activities as $activity)
                                <div class="flex items-start group">
                                    <div class="flex-shrink-0 relative">
                                        <div class="w-10 h-10 bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="h-5 w-5 text-{{ $activity['color'] }}-600 dark:text-{{ $activity['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($activity['icon'] === 'user-add')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                @elseif($activity['icon'] === 'arrow-up')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                @elseif($activity['icon'] === 'check-circle')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                @elseif($activity['icon'] === 'star')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                @elseif($activity['icon'] === 'refresh')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                @elseif($activity['icon'] === 'download')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                @endif
                                            </svg>
                                        </div>
                                        @if($loop->first)
                                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full animate-ping"></div>
                                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="text-sm text-gray-900 dark:text-white">
                                            <span class="font-semibold">{{ $activity['user'] }}</span>
                                            {{ $activity['action'] }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $activity['time'] }}</p>
                                    </div>
                                    <button class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <button onclick="viewAllActivity()" class="w-full px-4 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5 shadow-md hover:shadow-lg">
                                    View all activity
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Quick Actions
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Frequently used actions</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @php
                                $actions = [
                                    ['title' => 'Add User', 'icon' => 'user-add', 'color' => 'blue', 'url' =>route('users.index')],
                                    ['title' => 'Upload Photo', 'icon' => 'camera', 'color' => 'green', 'url' => route('gallery.create')],
                                    ['title' => 'Create Report', 'icon' => 'document-text', 'color' => 'purple', 'url' => '#'],
                                    ['title' => 'Manage Team', 'icon' => 'users', 'color' => 'orange', 'url' => '#'],
                                    ['title' => 'Settings', 'icon' => 'cog', 'color' => 'indigo', 'url' => '#'],
                                    ['title' => 'Analytics', 'icon' => 'chart-bar', 'color' => 'pink', 'url' => '#'],
                                    ['title' => 'Messages', 'icon' => 'mail', 'color' => 'teal', 'url' => '#'],
                                    ['title' => 'Calendar', 'icon' => 'calendar', 'color' => 'red', 'url' => '#'],
                                ];
                            @endphp
                            
                            @foreach($actions as $action)
                            <a href="{{ $action['url'] }}" class="group">
                                <div class="relative p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-{{ $action['color'] }}-300 dark:hover:border-{{ $action['color'] }}-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                    <div class="flex flex-col items-center text-center">
                                        <div class="p-3 bg-{{ $action['color'] }}-100 dark:bg-{{ $action['color'] }}-900/30 rounded-lg group-hover:bg-{{ $action['color'] }}-200 dark:group-hover:bg-{{ $action['color'] }}-900/50 transition-colors mb-3">
                                            <svg class="h-6 w-6 text-{{ $action['color'] }}-600 dark:text-{{ $action['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($action['icon'] === 'user-add')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                @elseif($action['icon'] === 'camera')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                @elseif($action['icon'] === 'document-text')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                @elseif($action['icon'] === 'users')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.67 3.913a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                @elseif($action['icon'] === 'cog')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                @elseif($action['icon'] === 'chart-bar')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                @elseif($action['icon'] === 'mail')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                @elseif($action['icon'] === 'calendar')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                @elseif($action['icon'] === 'question-mark-circle')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                @endif
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-{{ $action['color'] }}-600 dark:group-hover:text-{{ $action['color'] }}-400 transition-colors">
                                            {{ $action['title'] }}
                                        </span>
                                    </div>
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="h-4 w-4 text-{{ $action['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Recent Orders
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Track and manage customer orders</p>
                            </div>
                            <button onclick="refreshOrders()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <svg class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Order ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Customer
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px 6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Amount
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @php
                                        $orders = [
                                            ['id' => '#ORD-7841', 'customer' => 'John Carter', 'status' => 'Delivered', 'amount' => '$1,249', 'date' => 'Today, 10:24 AM'],
                                            ['id' => '#ORD-7840', 'customer' => 'Sophie Moore', 'status' => 'Processing', 'amount' => '$890', 'date' => 'Yesterday, 3:45 PM'],
                                            ['id' => '#ORD-7839', 'customer' => 'Alex Turner', 'status' => 'Pending', 'amount' => '$2,150', 'date' => 'Oct 12, 9:15 AM'],
                                            ['id' => '#ORD-7838', 'customer' => 'Mia Garcia', 'status' => 'Delivered', 'amount' => '$749', 'date' => 'Oct 10, 2:30 PM'],
                                            ['id' => '#ORD-7837', 'customer' => 'Robert Brown', 'status' => 'Cancelled', 'amount' => '$1,399', 'date' => 'Oct 8, 11:20 AM'],
                                        ];
                                    @endphp
                                    
                                    @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $order['id'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $order['date'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        {{ substr($order['customer'], 0, 1) }}
                                                    </span>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order['customer'] }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">Customer</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusConfig = [
                                                    'Delivered' => ['color' => 'green', 'icon' => 'check'],
                                                    'Processing' => ['color' => 'blue', 'icon' => 'refresh'],
                                                    'Pending' => ['color' => 'yellow', 'icon' => 'clock'],
                                                    'Cancelled' => ['color' => 'red', 'icon' => 'x'],
                                                ];
                                            @endphp
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $statusConfig[$order['status']]['color'] }}-100 dark:bg-{{ $statusConfig[$order['status']]['color'] }}-900/30 text-{{ $statusConfig[$order['status']]['color'] }}-800 dark:text-{{ $statusConfig[$order['status']]['color'] }}-400">
                                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($statusConfig[$order['status']]['icon'] === 'check')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    @elseif($statusConfig[$order['status']]['icon'] === 'refresh')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    @elseif($statusConfig[$order['status']]['icon'] === 'clock')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    @elseif($statusConfig[$order['status']]['icon'] === 'x')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    @endif
                                                </svg>
                                                {{ $order['status'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $order['amount'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button onclick="viewOrder('{{ $order['id'] }}')" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                                                    <svg class="h-4 w-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                                <button onclick="editOrder('{{ $order['id'] }}')" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                                                    <svg class="h-4 w-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Showing 5 of 124 orders
                            </div>
                            <a href="#" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                                View all orders
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark ::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        /* Animation for pulse */
        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 0.8;
            }
            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }
        
        .animate-ping-ring {
            animation: pulse-ring 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        
        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
    </style>

    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                document.getElementById('lightModeIcon').classList.remove('hidden');
                document.getElementById('darkModeIcon').classList.add('hidden');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                document.getElementById('darkModeIcon').classList.remove('hidden');
                document.getElementById('lightModeIcon').classList.add('hidden');
            }
        }

        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.getElementById('darkModeIcon').classList.remove('hidden');
            document.getElementById('lightModeIcon').classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            document.getElementById('lightModeIcon').classList.remove('hidden');
            document.getElementById('darkModeIcon').classList.add('hidden');
        }

        // Notification dropdown
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        
        notificationBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', () => {
            notificationDropdown.classList.add('hidden');
        });
        
        // Prevent dropdown from closing when clicking inside
        notificationDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // Time range selector for chart
        function changeTimeRange(range) {
            // Reset all buttons
            const buttons = ['btn-7d', 'btn-30d', 'btn-ytd'];
            buttons.forEach(btnId => {
                const btn = document.getElementById(btnId);
                btn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-200', 'dark:hover:bg-gray-600');
            });

            // Highlight active button
            const activeBtn = document.getElementById(`btn-${range}`);
            activeBtn.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-200', 'dark:hover:bg-gray-600');
            activeBtn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');

            // Update chart data based on range
            let labels, data;
            switch(range) {
                case '7d':
                    labels = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'];
                    data = [12000, 15000, 18000, 14000, 22000, 19000, 25000];
                    break;
                case '30d':
                    labels = Array.from({length: 30}, (_, i) => `Day ${i + 1}`);
                    data = Array.from({length: 30}, () => Math.floor(Math.random() * 30000) + 10000);
                    break;
                case 'ytd':
                default:
                    labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    data = [65000, 59000, 80000, 81000, 56000, 55000, 70000, 75000, 85000, 78000, 82000, 90000];
                    break;
            }

            revenueChart.data.labels = labels;
            revenueChart.data.datasets[0].data = data;
            revenueChart.update();
        }

        // View all activity
        function viewAllActivity() {
            alert('Redirecting to activity page...');
        }

        // Refresh orders
        function refreshOrders() {
            // Add loading animation
            const refreshBtn = document.querySelector('[onclick="refreshOrders()"]');
            refreshBtn.classList.add('animate-spin');
            
            setTimeout(() => {
                refreshBtn.classList.remove('animate-spin');
                alert('Orders refreshed!');
            }, 1000);
        }

        // View order details
        function viewOrder(orderId) {
            alert(`Viewing details for order: ${orderId}`);
        }

        // Edit order
        function editOrder(orderId) {
            alert(`Editing order: ${orderId}`);
        }

        // View stat details
        function viewStatDetails(statName) {
            alert(`Viewing detailed analytics for: ${statName}`);
        }

        // Chart interaction
        document.querySelectorAll('[onmouseenter]').forEach(el => {
            el.addEventListener('mouseenter', function() {
                const value = this.getAttribute('title').split(': ')[1];
                // You could show a tooltip or update a display element here
            });
        });
    </script>
</x-app-layout>