@php
    use App\Models\Gallery;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | Tourism Portal</title>
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
        
        .sidebar-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        }
        
        /* Image loading states */
        .image-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .image-container img {
            opacity: 0;
            transition: opacity 0.4s ease-in-out;
        }
        
        .image-container img.loaded {
            opacity: 1;
        }
        
        .image-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 25%, #bae6fd 50%, #7dd3fc 75%, #0ea5e9 100%);
            background-size: 400% 400%;
            animation: gradient-shift 8s ease infinite;
        }
        
        .image-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 50%, #fca5a5 100%);
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

        /* Lightbox */
        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        .lightbox.active {
            opacity: 1;
            visibility: visible;
        }
        
        .lightbox img {
            max-width: 90%;
            max-height: 90vh;
            border-radius: 8px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        

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
                                    <i class="fas fa-images mr-3 text-primary-600 dark:text-primary-400"></i>
                                    Photo Gallery
                                    <span class="ml-3 text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-bold px-3 py-1 rounded-full">BROWSE</span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-camera text-xs mr-2"></i>
                                    {{ $galleries->total() }} photos available
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
                            
                            <!-- Back to Dashboard -->
                            <a href="{{ route('dashboard') }}"
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3 group">
                                <i class="fas fa-home text-lg"></i>
                                Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto">
                    
                    <!-- Gallery Header -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Explore Photos</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">Browse beautiful travel moments</p>
                        </div>
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            <button class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-th-large text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Gallery Grid -->
                    @if($galleries->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($galleries as $index => $gallery)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700 animate-fade-in cursor-pointer"
                             style="animation-delay: {{ $index * 0.05 }}s"
                             onclick="openLightbox('{{ asset('storage/' . $gallery->image_path) }}', '{{ $gallery->title }}')">
                            
                            <!-- Image Container -->
                            <div class="relative h-64 overflow-hidden bg-gray-100 dark:bg-gray-700">
                                <div class="image-container">
                                    @if($gallery->image_path)
                                        <img 
                                            src="{{ asset('storage/' . $gallery->image_path) }}"
                                            alt="{{ $gallery->title }}"
                                            class="w-full h-64 object-cover transition-all duration-500 hover:scale-110"
                                            onload="handleImageLoad(this)"
                                            onerror="handleImageError(this)"
                                            loading="lazy"
                                        >
                                    @endif
                                    
                                    <!-- Fallback placeholder -->
                                    <div class="image-placeholder">
                                        <div class="w-16 h-16 rounded-full bg-white/50 dark:bg-gray-800/50 flex items-center justify-center mb-3">
                                            <i class="fas fa-image text-gray-500 dark:text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm text-center font-medium px-4">{{ $gallery->title }}</p>
                                    </div>
                                </div>
                                
                                <!-- Hover overlay with view icon -->
                                <div class="absolute inset-0 bg-black/0 hover:bg-black/40 transition-colors duration-300 flex items-center justify-center">
                                    <div class="opacity-0 hover:opacity-100 transition-opacity duration-300">
                                        <div class="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center">
                                            <i class="fas fa-expand text-gray-700 text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg truncate mb-2">{{ $gallery->title }}</h3>
                                
                                @if($gallery->description)
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">{{ $gallery->description }}</p>
                                @endif

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-blue-400 flex items-center justify-center text-white font-bold text-sm mr-3">
                                            {{ substr($gallery->user ? $gallery->user->name : 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $gallery->user ? $gallery->user->name : 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $gallery->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3 text-gray-400">
                                        <span class="flex items-center text-sm">
                                            <i class="fas fa-eye mr-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-lg border border-gray-100 dark:border-gray-700 animate-bounce-in">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-purple-100 to-pink-50 dark:from-purple-900/30 dark:to-pink-800/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-images text-purple-500 dark:text-purple-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Photos Yet</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-8">Check back later for amazing travel photos!</p>
                            <a href="{{ route('dashboard') }}"
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-3">
                                <i class="fas fa-home text-lg"></i>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Pagination -->
                    @if($galleries->hasPages())
                    <div class="mt-10 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Showing {{ $galleries->firstItem() }} to {{ $galleries->lastItem() }} of {{ $galleries->total() }} photos
                            </p>
                            <div class="flex space-x-2">
                                @if($galleries->onFirstPage())
                                <button disabled class="px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-400 text-sm">
                                    <i class="fas fa-chevron-left mr-2"></i> Previous
                                </button>
                                @else
                                <a href="{{ $galleries->previousPageUrl() }}" class="px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 text-sm">
                                    <i class="fas fa-chevron-left mr-2"></i> Previous
                                </a>
                                @endif
                                
                                @if($galleries->hasMorePages())
                                <a href="{{ $galleries->nextPageUrl() }}" class="px-4 py-2.5 bg-gradient-to-r from-primary-600 to-blue-500 text-white rounded-xl text-sm shadow-sm hover:shadow">
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
            </main>
        </div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <div class="absolute top-4 right-4">
            <button onclick="closeLightbox()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div class="text-center">
            <img id="lightboxImage" src="" alt="">
            <p id="lightboxCaption" class="text-white mt-4 text-lg font-medium"></p>
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

        // Image handling functions
        function handleImageLoad(img) {
            img.classList.add('loaded');
            const placeholder = img.nextElementSibling;
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        }

        function handleImageError(img) {
            img.style.display = 'none';
            const placeholder = img.nextElementSibling;
            if (placeholder) {
                placeholder.classList.add('image-error');
                placeholder.style.display = 'flex';
            }
        }

        // Lightbox functions
        function openLightbox(imageSrc, title) {
            document.getElementById('lightboxImage').src = imageSrc;
            document.getElementById('lightboxCaption').textContent = title;
            document.getElementById('lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close lightbox on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>
</body>
</html>
