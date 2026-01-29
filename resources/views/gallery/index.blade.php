<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-slate-800 tracking-tight">
                {{ __('Photo Gallery') }}
            </h2>

            <button onclick="openUploadModal()"
                class="bg-blue-600 hover:bg-blue-700 text-black font-semibold
                       py-2.5 px-6 rounded-lg shadow-sm
                       transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4"/>
                </svg>
                Upload Photo
            </button>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-red-800 mb-2">
                        Please correct the following:
                    </h3>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Gallery Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($galleries as $gallery)
                    <div class="bg-white rounded-xl border border-gray-200 shadow hover:shadow-md transition overflow-hidden">

                        {{-- Image --}}
                        <div class="relative aspect-square overflow-hidden">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}"
                                alt="{{ $gallery->title }}"
                                class="w-full h-full object-cover hover:scale-105 transition duration-300">
                            <div class="absolute inset-0 bg-black/20 opacity-0 hover:opacity-100 transition"></div>
                        </div>

                        {{-- Content --}}
                        <div class="p-4">
                            <h3 class="font-semibold text-slate-900 text-base mb-1 truncate">
                                {{ $gallery->title }}
                            </h3>

                            @if($gallery->description)
                                <p class="text-slate-600 text-sm leading-relaxed line-clamp-2 mb-3">
                                    {{ $gallery->description }}
                                </p>
                            @else
                                <p class="text-slate-400 text-sm italic mb-3">
                                    No description provided
                                </p>
                            @endif

                            <div class="flex items-center justify-between pt-3 mt-2 border-t border-gray-200">
                                <span class="text-sm text-slate-600 font-medium">
                                    {{ $gallery->user ? $gallery->user->name : 'Unknown User' }}
                                </span>

                                @if(auth()->id() === $gallery->user_id)
                                    <form action="{{ route('gallery.destroy', $gallery) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this photo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center gap-1 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                       a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                                       m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="col-span-full text-center py-20">
                        <h3 class="text-lg font-semibold text-slate-800 mb-2">
                            No Photos Yet
                        </h3>
                        <p class="text-slate-600 text-sm mb-6">
                            Upload your first photo to start the gallery.
                        </p>
                        <button onclick="openUploadModal()"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                            Upload Photo
                        </button>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($galleries->hasPages())
                <div class="mt-10">
                    {{ $galleries->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Upload Modal --}}
    <div id="uploadModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 flex justify-between items-center">
                <h3 class="text-white font-semibold text-lg">Upload Photo</h3>
                <button onclick="closeUploadModal()" class="text-white/80 hover:text-white">
                    ✕
                </button>
            </div>

            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data"
                  class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-slate-700 font-medium text-sm mb-2">Title *</label>
                    <input type="text" name="title" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 text-slate-800">
                </div>

                <div>
                    <label class="block text-slate-700 font-medium text-sm mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 text-slate-800"></textarea>
                </div>

                <div>
                    <label class="block text-slate-700 font-medium text-sm mb-2">Photo *</label>
                    <input type="file" name="image" required
                        class="block w-full text-sm text-slate-600">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeUploadModal()"
                        class="px-4 py-2 text-slate-600 hover:text-slate-900">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-black font-semibold px-5 py-2 rounded-lg">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        function openUploadModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-app-layout>
