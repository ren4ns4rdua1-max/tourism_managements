<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback | Tourism Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: { 500: '#3b82f6', 600: '#2563eb' },
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 font-sans min-h-screen">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        @include('layouts.sidebar-admin')

        <div class="flex-1 flex flex-col overflow-hidden lg:pl-64">
            <header class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-700 shadow-sm sticky top-0 z-10">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent flex items-center gap-3">
                                <i class="fas fa-comment-dots text-3xl"></i>
                                Customer Feedback
                                <span class="text-xs bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 text-indigo-700 dark:text-indigo-300 font-bold px-3 py-1 rounded-full shadow-sm">
                                    {{ $feedbacks->count() ?? 0 }} feedbacks
                                </span>
                            </h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage customer reviews and feedback</p>
                        </div>
                        <a href="{{ route('feedback.create') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-3 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Add Feedback
                        </a>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-7xl mx-auto space-y-6">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-white/50 dark:border-gray-700/50 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                                    <i class="fas fa-star text-white text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Total Feedbacks</p>
                                    <p class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        {{ $feedbacks->count() ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-white/50 dark:border-gray-700/50 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-lg">
                                    <i class="fas fa-thumbs-up text-white text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Positive</p>
                                    <p class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                        {{ $feedbacks->where('rating', '>=', 4)->count() ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-white/50 dark:border-gray-700/50 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-amber-500 to-orange-600 rounded-2xl shadow-lg">
                                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Needs Attention</p>
                                    <p class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                        {{ $feedbacks->where('rating', 3)->count() ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-white/50 dark:border-gray-700/50 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-rose-500 to-pink-600 rounded-2xl shadow-lg">
                                    <i class="fas fa-thumbs-down text-white text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Negative</p>
                                    <p class="text-3xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                                        {{ $feedbacks->where('rating', '<', 3)->count() ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feedback Table -->
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                        <div class="p-6 border-b border-white/50 dark:border-gray-700/50 bg-gradient-to-r from-slate-50 to-blue-50 dark:from-gray-800/50 dark:to-slate-800/50">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                <i class="fas fa-list text-indigo-600"></i>
                                All Feedbacks
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50/50 dark:bg-gray-800/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rating</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Comment</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($feedbacks as $feedback)
                                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 dark:hover:from-indigo-950/30 dark:hover:to-purple-950/30 transition-all duration-200">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold shadow-lg">
                                                    {{ substr($feedback->guest_name ?? 'Guest', 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $feedback->guest_name ?? 'Anonymous' }}</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $feedback->guest_email ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                                @endfor
                                                <span class="ml-2 text-sm font-bold text-gray-700 dark:text-gray-300">({{ $feedback->rating }}/5)</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <p class="text-gray-900 dark:text-white font-medium leading-relaxed max-w-md">{{ Str::limit($feedback->feedback, 120) }}</p>
                                            @if(strlen($feedback->feedback) > 120)
                                                <button class="text-indigo-600 dark:text-indigo-400 text-sm hover:underline mt-1">Read more</button>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 text-sm font-medium text-gray-900 dark:text-white">
                                            <span class="text-xs bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 px-3 py-1 rounded-full font-semibold">
                                                {{ $feedback->created_at->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right text-sm font-medium">
                                            <div class="flex items-center gap-2 justify-end">
                                                <a href="#" class="p-2 text-indigo-600 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 rounded-xl transition-colors">
                                                    <i class="fas fa-reply"></i>
                                                </a>
                                                <button class="p-2 text-amber-600 hover:bg-amber-100 dark:hover:bg-amber-900/50 rounded-xl transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="#" method="POST" class="inline" onsubmit="return confirm('Delete feedback?')">
                                                    @csrf @method('DELETE')
                                                    <button class="p-2 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-xl transition-colors">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center space-y-4">
                                                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-3xl flex items-center justify-center">
                                                    <i class="fas fa-comments text-3xl text-gray-400"></i>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">No feedbacks yet</h3>
                                                    <p class="text-gray-500 dark:text-gray-400">Customer feedbacks will appear here.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        if (localStorage.getItem('darkMode') === 'true') document.documentElement.classList.add('dark');
    </script>
</body>
</html>
