<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Bookings - Admin | Travel Management</title>
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
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        @include('layouts.sidebar-admin')
        <div class="flex-1 flex flex-col overflow-hidden lg:pl-64">
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                <i class="fas fa-truck-medical text-amber-500"></i>
                                Vehicle Bookings Management
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Approve, edit or manage transportation bookings</p>
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-7xl mx-auto space-y-6">
                    @if (session('success'))
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                <span class="font-medium text-green-800 dark:text-green-200">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">All Vehicle Bookings</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vehicle</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dates</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Guests</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($bookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold">
                                                    <i class="fas {{ $booking->vehicle->typeIcon }}"></i>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $booking->vehicle->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ ucfirst($booking->vehicle->type) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $booking->guest_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $booking->guest_email }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <p class="font-medium">{{ $booking->check_in_date->format('M d') }}</p>
                                            @if($booking->check_out_date)
                                            <p class="text-xs text-gray-500">to {{ $booking->check_out_date->format('M d') }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $booking->number_of_guests }} guests
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-lg text-emerald-600 dark:text-emerald-400">
                                            ₱{{ number_format($booking->total_price ?? 0, 2) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $status = $booking->status;
                                                $colors = [
                                                    'pending' => 'yellow',
                                                    'confirmed' => 'green',
                                                    'cancelled' => 'gray'
                                                ];
                                                $color = $colors[$status] ?? 'gray';
                                            @endphp
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 text-{{ $color }}-800 dark:text-{{ $color }}-200">
                                                <i class="fas fa-circle text-{{ $color }}-500 text-xs"></i>
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                            <a href="#" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="#" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <div class="flex gap-1 mt-1">
                                                <form action="{{ route('bookings.manage.confirm', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg transition-colors">
                                                        Confirm
                                                    </button>
                                                </form>
                                                <form action="{{ route('bookings.manage.cancel', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="px-3 py-1 bg-gray-500 hover:bg-gray-600 text-white text-xs font-bold rounded-lg transition-colors">
                                                        Cancel
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mb-4">
                                                    <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">No Bookings</h3>
                                                <p class="text-gray-500 dark:text-gray-400">No transportation bookings found.</p>
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
</body>
</html>
