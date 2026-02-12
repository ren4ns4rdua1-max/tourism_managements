<!DOCTYPE html>
<html lang="en" class="scroll-smooth h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photo | Photo Gallery</title>
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
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
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
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        .image-preview-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .image-preview {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 1rem;
            border: 3px solid #e5e7eb;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.2);
        }

        .dark .image-preview {
            border-color: #4b5563;
        }

        .upload-area {
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.05);
        }

        .dark .upload-area:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .upload-area.dragover {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.1);
            transform: scale(1.01);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        .dark .upload-area.dragover {
            background-color: rgba(16, 185, 129, 0.15);
        }

        /* Ensure visibility of all elements */
        .visible {
            display: block !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans h-full">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        
        @include('layouts.sidebar-admin')

        <!-- Mobile Menu Button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="p-2 rounded-lg bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden min-h-screen">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-30">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center pl-12 lg:pl-0">
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <i class="fas fa-cloud-upload-alt mr-2 sm:mr-3 text-blue-500"></i>
                                    <span>Upload Photo</span>
                                </h1>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-images text-xs mr-2"></i>
                                    <span class="hidden sm:inline">Share your amazing moments with the gallery</span>
                                    <span class="sm:hidden">Add to gallery</span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2 sm:p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-base sm:text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-base sm:text-lg hidden dark:inline"></i>
                            </button>
                            
                            <!-- Back Button -->
                            <a href="{{ route('gallery.index') }}"
                                class="px-3 sm:px-4 py-2 sm:py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors font-semibold flex items-center gap-2 text-sm sm:text-base">
                                <i class="fas fa-arrow-left"></i>
                                <span class="hidden sm:inline">Back to Gallery</span>
                                <span class="sm:hidden">Back</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="w-full px-4 sm:px-6 py-6 sm:py-8">
                    <div class="max-w-4xl mx-auto">

                        <!-- Progress Steps -->
                        <div class="mb-6 sm:mb-8">
                            <div class="flex items-center justify-center space-x-3 sm:space-x-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-r from-blue-600 to-blue-500 text-white flex items-center justify-center font-bold shadow-lg text-sm sm:text-base">
                                        <i class="fas fa-upload"></i>
                                    </div>
                                    <div class="ml-2 sm:ml-3">
                                        <p class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white">Upload Photo</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Step 1 of 2</p>
                                    </div>
                                </div>
                                <div class="w-12 sm:w-16 h-1 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-bold text-sm sm:text-base">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="ml-2 sm:ml-3">
                                        <p class="text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400">Complete</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">Step 2 of 2</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alerts Section -->
                        @if($errors->any())
                        <div class="mb-6 sm:mb-8">
                            <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-4 sm:p-5 shadow-lg animate-fade-in">
                                <div class="flex items-start">
                                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800/50 flex items-center justify-center mr-3 sm:mr-4 mt-1 flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-red-800 dark:text-red-300 text-base sm:text-lg mb-2">Please correct the following errors:</h3>
                                        <ul class="list-disc list-inside text-red-700 dark:text-red-400 space-y-1 text-sm">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Upload Form Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                            
                            <!-- Form Header -->
                            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white mr-3 sm:mr-4 shadow-lg">
                                        <i class="fas fa-camera text-lg sm:text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Photo Details</h3>
                                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300">Fill in the information about your photo</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Body -->
                            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-5 sm:space-y-6">
                                @csrf

                                <!-- Photo Title -->
                                <div>
                                    <label for="title" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Photo Title <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-heading text-gray-400 text-sm"></i>
                                        </div>
                                        <input type="text" 
                                               name="title" 
                                               id="title" 
                                               value="{{ old('title') }}"
                                               class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm sm:text-base @error('title') border-red-500 ring-2 ring-red-500 @enderror"
                                               placeholder="Give your photo a descriptive title..."
                                               required>
                                    </div>
                                    @error('title')
                                        <p class="text-red-500 text-xs sm:text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Photo Description -->
                                <div>
                                    <label for="description" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Description <span class="text-gray-400 text-xs">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute top-3 sm:top-4 left-3 sm:left-4 pointer-events-none">
                                            <i class="fas fa-align-left text-gray-400 text-sm"></i>
                                        </div>
                                        <textarea name="description" 
                                                  id="description" 
                                                  rows="4"
                                                  class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none text-sm sm:text-base"
                                                  placeholder="Share the story behind this photo...">{{ old('description') }}</textarea>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Add context, location, or any details about this moment
                                    </p>
                                </div>

                                <!-- Photo Upload -->
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Upload Photo <span class="text-red-500">*</span>
                                    </label>
                                    
                                    <div class="upload-area border-3 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-6 sm:p-8 text-center bg-gray-50 dark:bg-gray-700/30"
                                         id="uploadArea"
                                         ondrop="handleDrop(event)"
                                         ondragover="handleDragOver(event)"
                                         ondragleave="handleDragLeave(event)">
                                        
                                        <div id="uploadPrompt">
                                            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-3 sm:mb-4 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center animate-pulse-slow">
                                                <i class="fas fa-cloud-upload-alt text-blue-500 dark:text-blue-400 text-2xl sm:text-3xl"></i>
                                            </div>
                                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-2">
                                                Drop your photo here
                                            </h3>
                                            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mb-2">or click to browse</p>
                                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4 sm:mb-6">
                                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                                JPG, PNG, GIF up to 2MB
                                            </p>
                                            <input type="file" 
                                                   name="image" 
                                                   id="image" 
                                                   accept="image/*"
                                                   class="hidden"
                                                   onchange="previewImage(this)"
                                                   required>
                                            <button type="button" 
                                                    onclick="document.getElementById('image').click()"
                                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-2.5 sm:py-3 px-6 sm:px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-2 text-sm sm:text-base">
                                                <i class="fas fa-folder-open"></i>
                                                Choose File
                                            </button>
                                        </div>

                                        <!-- Image Preview -->
                                        <div id="imagePreview" class="hidden">
                                            <div class="image-preview-container">
                                                <img id="previewImg" src="" alt="Preview" class="image-preview">
                                                <button type="button" 
                                                        onclick="removePreview()" 
                                                        class="absolute top-2 right-2 sm:top-3 sm:right-3 w-9 h-9 sm:w-10 sm:h-10 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg z-10">
                                                    <i class="fas fa-times text-base sm:text-lg"></i>
                                                </button>
                                                <div class="absolute bottom-2 left-2 sm:bottom-3 sm:left-3 bg-black/70 backdrop-blur-sm text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm">
                                                    <i class="fas fa-check-circle text-green-400 mr-2"></i>
                                                    Photo ready to upload
                                                </div>
                                            </div>
                                            <button type="button" 
                                                    onclick="document.getElementById('image').click()"
                                                    class="mt-3 sm:mt-4 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold text-xs sm:text-sm">
                                                <i class="fas fa-sync-alt mr-2"></i>
                                                Change Photo
                                            </button>
                                        </div>
                                    </div>
                                    
                                    @error('image')
                                        <p class="text-red-500 text-xs sm:text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Upload Tips -->
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10 p-4 sm:p-5 rounded-xl border border-blue-200 dark:border-blue-800">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center text-sm sm:text-base">
                                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                        Tips for great photos
                                    </h4>
                                    <ul class="space-y-2 text-xs sm:text-sm text-gray-600 dark:text-gray-300">
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                            <span>Use high-resolution images for best quality</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                            <span>Good lighting makes photos more appealing</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                            <span>Write descriptive titles to help others find your photos</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                            <span>Keep file sizes under 2MB for faster uploads</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Form Actions -->
                                <div class="pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                                        <a href="{{ route('gallery.index') }}" 
                                           class="px-5 sm:px-6 py-2.5 sm:py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold rounded-xl transition-colors text-center border-2 border-gray-200 dark:border-gray-600 text-sm sm:text-base">
                                            <i class="fas fa-times mr-2"></i>
                                            Cancel
                                        </a>
                                        <button type="submit"
                                                class="px-6 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 sm:gap-3 group text-sm sm:text-base">
                                            <i class="fas fa-cloud-upload-alt text-base sm:text-lg"></i>
                                            Upload Photo
                                            <i class="fas fa-arrow-right text-xs sm:text-sm group-hover:translate-x-1 transition-transform"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Additional Info Card -->
                        <div class="mt-4 sm:mt-6 bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 dark:border-gray-700">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0">
                                    <i class="fas fa-shield-alt text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2 text-sm sm:text-base">Privacy & Safety</h4>
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300">
                                        Your photos are stored securely. Make sure you have the right to share the images you upload. 
                                        By uploading, you agree to our terms of service.
                                    </p>
                                </div>
                            </div>
                        </div>

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

        // Image preview function
        function previewImage(input) {
            const uploadPrompt = document.getElementById('uploadPrompt');
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    input.value = '';
                    return;
                }
                
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    uploadPrompt.classList.add('hidden');
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(file);
            }
        }

        // Remove preview function
        function removePreview() {
            const uploadPrompt = document.getElementById('uploadPrompt');
            const preview = document.getElementById('imagePreview');
            const imageInput = document.getElementById('image');
            
            imageInput.value = '';
            preview.classList.add('hidden');
            uploadPrompt.classList.remove('hidden');
        }

        // Drag and drop handlers
        function handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            document.getElementById('uploadArea').classList.add('dragover');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            document.getElementById('uploadArea').classList.remove('dragover');
        }

        function handleDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            document.getElementById('uploadArea').classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const imageInput = document.getElementById('image');
                
                // Create a new FileList-like object
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(files[0]);
                imageInput.files = dataTransfer.files;
                
                previewImage(imageInput);
            }
        }

        // Prevent default drag behaviors on the whole page
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Log any errors
        window.addEventListener('error', function(e) {
            console.error('Error:', e.message);
        });

        // Ensure all elements are visible on load
        window.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded successfully');
        });
    </script>
</body>
</html>