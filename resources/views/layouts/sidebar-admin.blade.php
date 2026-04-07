<!-- Admin Sidebar -->
<aside class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800">

        {{-- Logo / Brand --}}
        <div class="h-16 flex items-center gap-3 px-5 border-b border-gray-200 dark:border-gray-800">
            <div class="w-8 h-8 rounded-lg bg-violet-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <span class="text-sm font-semibold text-gray-900 dark:text-white">Admin Panel</span>
        </div>

{{-- Navigation --}}
        <nav class="flex-1 py-3 px-3 space-y-0.5 h-[calc(100vh-16rem-3rem)] overflow-hidden">

            {{-- Section: Main --}}
            <p class="px-3 pt-1 pb-2 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                Main
            </p>

            <a href="{{ route('dashboard') }}"
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('dashboard'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('dashboard'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Dashboard</span>
            </a>

<a href="{{ route('destinations.index') }}" @role('admin')
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('destinations.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('destinations.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Tourist Management</span>
            </a>

<a href="{{ route('bookings.admin.index') }}" @role('admin')
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('bookings.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('bookings.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <span>Bookings</span>
                {{-- Optional badge: replace count with dynamic value --}}
                {{-- <span class="ml-auto text-xs font-medium px-2 py-0.5 rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/50 dark:text-violet-300">12</span> --}}
            </a>

            <a href="{{ route('hotel.index') }}"
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('hotel.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('hotel.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Hotel Management</span>
            </a>

            <a href="{{ route('tour-packages.index') }}"
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('tour-packages.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('tour-packages.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Tour Packages</span>
            </a>

            {{-- Section: Services --}}
            <p class="px-3 pt-4 pb-2 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                Services
            </p>


           

<a href="{{ route('payments.index') }}" @role('admin')
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('payments.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('payments.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4H7a2 2 0 01-2-2v-4a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2zM9 9h6v2H9V9z"/>
                </svg>
                <span>Payments</span>
            </a>

            {{-- Section: Content & Reports --}}
            <p class="px-3 pt-4 pb-2 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                Content &amp; Reports
            </p>

            <a href="{{ route('gallery.index') }}"
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('gallery.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('gallery.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Gallery</span>
            </a>

            <a href="{{ route('reports.index') }}"
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('reports.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('reports.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Reports</span>
            </a>

            <a href="{{ route('feedback.index') }}"
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('feedback.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('feedback.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <span>Feedback</span>
                {{-- Optional badge --}}
                {{-- <span class="ml-auto text-xs font-medium px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">3</span> --}}
            </a>

            <a href="{{ route('users.index') }}"
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('users.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('users.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0h-1"/>
                </svg>
                <span>Users</span>
            </a>
             <a href="{{ route('welcome-content.edit') }}"
               @class([
                   'group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150',
                   'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' => request()->routeIs('gallery.*'),
                   'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => !request()->routeIs('gallery.*'),
               ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>EDIT</span>
            </a>

        </nav>

        {{-- User Profile --}}
        <div class="border-t border-gray-200 dark:border-gray-800 p-3">
            <div x-data="{ open: false }" class="relative">

                <button @click="open = !open"
                        class="flex items-center w-full gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-150 text-left">
                    <div class="w-8 h-8 rounded-full bg-violet-600 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate leading-tight">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 truncate leading-tight">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform duration-150"
                         :class="{ 'rotate-180': open }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div x-show="open"
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute bottom-full left-0 right-0 mb-1 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm"
                     style="display: none;">

                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profile settings
                    </a>

                    <div class="border-t border-gray-100 dark:border-gray-800"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2.5 w-full px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Log out
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</aside>