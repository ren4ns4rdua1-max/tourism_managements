<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Explore, Discover, and Manage Tourism Experiences">
        <title>{{ config('app.name', 'Tourism Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|plus-jakarta-sans:300,400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                /* Simplified Tailwind CSS - Core colors and utilities only */
                :root {
                    --color-primary-50: #f0f9ff;
                    --color-primary-100: #e0f2fe;
                    --color-primary-200: #bae6fd;
                    --color-primary-300: #7dd3fc;
                    --color-primary-400: #38bdf8;
                    --color-primary-500: #0ea5e9;
                    --color-primary-600: #0284c7;
                    --color-primary-700: #0369a1;
                    --color-primary-800: #075985;
                    --color-primary-900: #0c4a6e;
                    --color-primary-950: #082f49;

                    --color-secondary-50: #f0fdf4;
                    --color-secondary-100: #dcfce7;
                    --color-secondary-200: #bbf7d0;
                    --color-secondary-300: #86efac;
                    --color-secondary-400: #4ade80;
                    --color-secondary-500: #22c55e;
                    --color-secondary-600: #16a34a;
                    --color-secondary-700: #15803d;
                    --color-secondary-800: #166534;
                    --color-secondary-900: #14532d;
                    --color-secondary-950: #052e16;

                    --color-accent-50: #fdf4ff;
                    --color-accent-100: #fae8ff;
                    --color-accent-200: #f5d0fe;
                    --color-accent-300: #f0abfc;
                    --color-accent-400: #e879f9;
                    --color-accent-500: #d946ef;
                    --color-accent-600: #c026d3;
                    --color-accent-700: #a21caf;
                    --color-accent-800: #86198f;
                    --color-accent-900: #701a75;
                    --color-accent-950: #4a044e;

                    /* Enhanced Tourism Colors */
                    --color-ocean-50: #f0fdff;
                    --color-ocean-100: #ccfbff;
                    --color-ocean-200: #99f6ff;
                    --color-ocean-300: #66f0ff;
                    --color-ocean-400: #33eaff;
                    --color-ocean-500: #00e4ff;
                    --color-ocean-600: #00b8cc;
                    --color-ocean-700: #008c99;
                    --color-ocean-800: #006066;
                    --color-ocean-900: #003333;

                    --color-sunset-50: #fff7ed;
                    --color-sunset-100: #ffedd5;
                    --color-sunset-200: #fed7aa;
                    --color-sunset-300: #fdba74;
                    --color-sunset-400: #fb923c;
                    --color-sunset-500: #f97316;
                    --color-sunset-600: #ea580c;
                    --color-sunset-700: #c2410c;
                    --color-sunset-800: #9a3412;
                    --color-sunset-900: #7c2d12;

                    --color-forest-50: #f7f9f7;
                    --color-forest-100: #e6f3e6;
                    --color-forest-200: #c7e5c7;
                    --color-forest-300: #a8d7a8;
                    --color-forest-400: #89c989;
                    --color-forest-500: #6abb6a;
                    --color-forest-600: #4a994a;
                    --color-forest-700: #3a7a3a;
                    --color-forest-800: #2a5a2a;
                    --color-forest-900: #1a3a1a;
                    
                    --color-gray-50: #f9fafb;
                    --color-gray-100: #f3f4f6;
                    --color-gray-200: #e5e7eb;
                    --color-gray-300: #d1d5db;
                    --color-gray-400: #9ca3af;
                    --color-gray-500: #6b7280;
                    --color-gray-600: #4b5563;
                    --color-gray-700: #374151;
                    --color-gray-800: #1f2937;
                    --color-gray-900: #111827;
                    --color-gray-950: #030712;
                    
                    --color-success: #10b981;
                    --color-warning: #f59e0b;
                    --color-danger: #ef4444;
                    --color-info: #3b82f6;
                }
                
                .dark {
                    --color-primary-50: #082f49;
                    --color-primary-100: #0c4a6e;
                    --color-primary-200: #075985;
                    --color-primary-300: #0369a1;
                    --color-primary-400: #0284c7;
                    --color-primary-500: #0ea5e9;
                    --color-primary-600: #38bdf8;
                    --color-primary-700: #7dd3fc;
                    --color-primary-800: #bae6fd;
                    --color-primary-900: #e0f2fe;
                    --color-primary-950: #f0f9ff;
                }
                
                /* Base utilities */
                .absolute { position: absolute; }
                .relative { position: relative; }
                .fixed { position: fixed; }
                .static { position: static; }
                .inset-0 { inset: 0; }
                .top-0 { top: 0; }
                .right-0 { right: 0; }
                .bottom-0 { bottom: 0; }
                .left-0 { left: 0; }
                .z-10 { z-index: 10; }
                .z-20 { z-index: 20; }
                
                /* Display */
                .block { display: block; }
                .inline-block { display: inline-block; }
                .inline { display: inline; }
                .flex { display: flex; }
                .inline-flex { display: inline-flex; }
                .grid { display: grid; }
                .hidden { display: none; }
                
                /* Flex & Grid */
                .flex-col { flex-direction: column; }
                .flex-row { flex-direction: row; }
                .flex-wrap { flex-wrap: wrap; }
                .items-center { align-items: center; }
                .items-start { align-items: flex-start; }
                .items-end { align-items: flex-end; }
                .justify-center { justify-content: center; }
                .justify-between { justify-content: space-between; }
                .justify-end { justify-content: flex-end; }
                .gap-2 { gap: 0.5rem; }
                .gap-3 { gap: 0.75rem; }
                .gap-4 { gap: 1rem; }
                .gap-6 { gap: 1.5rem; }
                .gap-8 { gap: 2rem; }
                .space-y-2 > * + * { margin-top: 0.5rem; }
                .space-y-4 > * + * { margin-top: 1rem; }
                .space-y-6 > * + * { margin-top: 1.5rem; }
                
                /* Sizing */
                .w-full { width: 100%; }
                .w-auto { width: auto; }
                .w-4 { width: 1rem; }
                .w-6 { width: 1.5rem; }
                .w-8 { width: 2rem; }
                .w-12 { width: 3rem; }
                .w-16 { width: 4rem; }
                .w-24 { width: 6rem; }
                .w-32 { width: 8rem; }
                .w-48 { width: 12rem; }
                .w-64 { width: 16rem; }
                .max-w-sm { max-width: 24rem; }
                .max-w-md { max-width: 28rem; }
                .max-w-lg { max-width: 32rem; }
                .max-w-xl { max-width: 36rem; }
                .max-w-2xl { max-width: 42rem; }
                .max-w-3xl { max-width: 48rem; }
                .max-w-4xl { max-width: 56rem; }
                .max-w-5xl { max-width: 64rem; }
                .max-w-6xl { max-width: 72rem; }
                .max-w-7xl { max-width: 80rem; }
                .min-w-0 { min-width: 0; }
                
                .h-full { height: 100%; }
                .h-screen { height: 100vh; }
                .min-h-screen { min-height: 100vh; }
                .h-4 { height: 1rem; }
                .h-6 { height: 1.5rem; }
                .h-8 { height: 2rem; }
                .h-12 { height: 3rem; }
                .h-16 { height: 4rem; }
                .h-24 { height: 6rem; }
                .h-32 { height: 8rem; }
                
                /* Spacing */
                .m-0 { margin: 0; }
                .m-2 { margin: 0.5rem; }
                .m-4 { margin: 1rem; }
                .mx-auto { margin-left: auto; margin-right: auto; }
                .mt-2 { margin-top: 0.5rem; }
                .mt-4 { margin-top: 1rem; }
                .mt-6 { margin-top: 1.5rem; }
                .mt-8 { margin-top: 2rem; }
                .mt-12 { margin-top: 3rem; }
                .mb-2 { margin-bottom: 0.5rem; }
                .mb-4 { margin-bottom: 1rem; }
                .mb-6 { margin-bottom: 1.5rem; }
                .mb-8 { margin-bottom: 2rem; }
                .mb-12 { margin-bottom: 3rem; }
                .ml-2 { margin-left: 0.5rem; }
                .ml-4 { margin-left: 1rem; }
                .mr-2 { margin-right: 0.5rem; }
                .mr-4 { margin-right: 1rem; }
                
                .p-0 { padding: 0; }
                .p-2 { padding: 0.5rem; }
                .p-4 { padding: 1rem; }
                .p-6 { padding: 1.5rem; }
                .p-8 { padding: 2rem; }
                .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
                .px-4 { padding-left: 1rem; padding-right: 1rem; }
                .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
                .px-8 { padding-left: 2rem; padding-right: 2rem; }
                .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
                .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
                .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
                .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
                .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
                .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
                .pt-2 { padding-top: 0.5rem; }
                .pt-4 { padding-top: 1rem; }
                .pt-6 { padding-top: 1.5rem; }
                .pt-8 { padding-top: 2rem; }
                .pb-2 { padding-bottom: 0.5rem; }
                .pb-4 { padding-bottom: 1rem; }
                .pb-6 { padding-bottom: 1.5rem; }
                .pb-8 { padding-bottom: 2rem; }
                
                /* Typography */
                .text-xs { font-size: 0.75rem; line-height: 1rem; }
                .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
                .text-base { font-size: 1rem; line-height: 1.5rem; }
                .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
                .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
                .text-2xl { font-size: 1.5rem; line-height: 2rem; }
                .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
                .text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
                .text-5xl { font-size: 3rem; line-height: 1; }
                
                .font-light { font-weight: 300; }
                .font-normal { font-weight: 400; }
                .font-medium { font-weight: 500; }
                .font-semibold { font-weight: 600; }
                .font-bold { font-weight: 700; }
                .font-extrabold { font-weight: 800; }
                
                .text-center { text-align: center; }
                .text-left { text-align: left; }
                .text-right { text-align: right; }
                
                .leading-tight { line-height: 1.25; }
                .leading-normal { line-height: 1.5; }
                .leading-relaxed { line-height: 1.625; }
                
                .tracking-tight { letter-spacing: -0.025em; }
                .tracking-normal { letter-spacing: 0; }
                .tracking-wide { letter-spacing: 0.025em; }
                
                /* Borders */
                .border { border-width: 1px; }
                .border-2 { border-width: 2px; }
                .border-0 { border-width: 0; }
                
                .border-solid { border-style: solid; }
                .border-dashed { border-style: dashed; }
                .border-dotted { border-style: dotted; }
                
                .rounded { border-radius: 0.25rem; }
                .rounded-sm { border-radius: 0.125rem; }
                .rounded-md { border-radius: 0.375rem; }
                .rounded-lg { border-radius: 0.5rem; }
                .rounded-xl { border-radius: 0.75rem; }
                .rounded-2xl { border-radius: 1rem; }
                .rounded-3xl { border-radius: 1.5rem; }
                .rounded-full { border-radius: 9999px; }
                
                .rounded-t-lg { border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
                .rounded-b-lg { border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; }
                .rounded-l-lg { border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem; }
                .rounded-r-lg { border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; }
                
                /* Colors - Light Mode */
                .bg-primary-50 { background-color: var(--color-primary-50); }
                .bg-primary-100 { background-color: var(--color-primary-100); }
                .bg-primary-200 { background-color: var(--color-primary-200); }
                .bg-primary-300 { background-color: var(--color-primary-300); }
                .bg-primary-400 { background-color: var(--color-primary-400); }
                .bg-primary-500 { background-color: var(--color-primary-500); }
                .bg-primary-600 { background-color: var(--color-primary-600); }
                .bg-primary-700 { background-color: var(--color-primary-700); }
                .bg-primary-800 { background-color: var(--color-primary-800); }
                .bg-primary-900 { background-color: var(--color-primary-900); }
                .bg-primary-950 { background-color: var(--color-primary-950); }
                
                .bg-secondary-50 { background-color: var(--color-secondary-50); }
                .bg-secondary-100 { background-color: var(--color-secondary-100); }
                .bg-secondary-200 { background-color: var(--color-secondary-200); }
                .bg-secondary-300 { background-color: var(--color-secondary-300); }
                .bg-secondary-400 { background-color: var(--color-secondary-400); }
                .bg-secondary-500 { background-color: var(--color-secondary-500); }
                .bg-secondary-600 { background-color: var(--color-secondary-600); }
                .bg-secondary-700 { background-color: var(--color-secondary-700); }
                .bg-secondary-800 { background-color: var(--color-secondary-800); }
                .bg-secondary-900 { background-color: var(--color-secondary-900); }
                .bg-secondary-950 { background-color: var(--color-secondary-950); }
                
                .bg-accent-50 { background-color: var(--color-accent-50); }
                .bg-accent-100 { background-color: var(--color-accent-100); }
                .bg-accent-200 { background-color: var(--color-accent-200); }
                .bg-accent-300 { background-color: var(--color-accent-300); }
                .bg-accent-400 { background-color: var(--color-accent-400); }
                .bg-accent-500 { background-color: var(--color-accent-500); }
                .bg-accent-600 { background-color: var(--color-accent-600); }
                .bg-accent-700 { background-color: var(--color-accent-700); }
                .bg-accent-800 { background-color: var(--color-accent-800); }
                .bg-accent-900 { background-color: var(--color-accent-900); }
                .bg-accent-950 { background-color: var(--color-accent-950); }
                
                .bg-gray-50 { background-color: var(--color-gray-50); }
                .bg-gray-100 { background-color: var(--color-gray-100); }
                .bg-gray-200 { background-color: var(--color-gray-200); }
                .bg-gray-300 { background-color: var(--color-gray-300); }
                .bg-gray-400 { background-color: var(--color-gray-400); }
                .bg-gray-500 { background-color: var(--color-gray-500); }
                .bg-gray-600 { background-color: var(--color-gray-600); }
                .bg-gray-700 { background-color: var(--color-gray-700); }
                .bg-gray-800 { background-color: var(--color-gray-800); }
                .bg-gray-900 { background-color: var(--color-gray-900); }
                .bg-gray-950 { background-color: var(--color-gray-950); }
                
                .bg-white { background-color: white; }
                .bg-black { background-color: black; }
                .bg-transparent { background-color: transparent; }
                
                /* Text Colors */
                .text-primary-50 { color: var(--color-primary-50); }
                .text-primary-100 { color: var(--color-primary-100); }
                .text-primary-200 { color: var(--color-primary-200); }
                .text-primary-300 { color: var(--color-primary-300); }
                .text-primary-400 { color: var(--color-primary-400); }
                .text-primary-500 { color: var(--color-primary-500); }
                .text-primary-600 { color: var(--color-primary-600); }
                .text-primary-700 { color: var(--color-primary-700); }
                .text-primary-800 { color: var(--color-primary-800); }
                .text-primary-900 { color: var(--color-primary-900); }
                .text-primary-950 { color: var(--color-primary-950); }
                
                .text-secondary-50 { color: var(--color-secondary-50); }
                .text-secondary-100 { color: var(--color-secondary-100); }
                .text-secondary-200 { color: var(--color-secondary-200); }
                .text-secondary-300 { color: var(--color-secondary-300); }
                .text-secondary-400 { color: var(--color-secondary-400); }
                .text-secondary-500 { color: var(--color-secondary-500); }
                .text-secondary-600 { color: var(--color-secondary-600); }
                .text-secondary-700 { color: var(--color-secondary-700); }
                .text-secondary-800 { color: var(--color-secondary-800); }
                .text-secondary-900 { color: var(--color-secondary-900); }
                .text-secondary-950 { color: var(--color-secondary-950); }
                
                .text-accent-50 { color: var(--color-accent-50); }
                .text-accent-100 { color: var(--color-accent-100); }
                .text-accent-200 { color: var(--color-accent-200); }
                .text-accent-300 { color: var(--color-accent-300); }
                .text-accent-400 { color: var(--color-accent-400); }
                .text-accent-500 { color: var(--color-accent-500); }
                .text-accent-600 { color: var(--color-accent-600); }
                .text-accent-700 { color: var(--color-accent-700); }
                .text-accent-800 { color: var(--color-accent-800); }
                .text-accent-900 { color: var(--color-accent-900); }
                .text-accent-950 { color: var(--color-accent-950); }
                
                .text-gray-50 { color: var(--color-gray-50); }
                .text-gray-100 { color: var(--color-gray-100); }
                .text-gray-200 { color: var(--color-gray-200); }
                .text-gray-300 { color: var(--color-gray-300); }
                .text-gray-400 { color: var(--color-gray-400); }
                .text-gray-500 { color: var(--color-gray-500); }
                .text-gray-600 { color: var(--color-gray-600); }
                .text-gray-700 { color: var(--color-gray-700); }
                .text-gray-800 { color: var(--color-gray-800); }
                .text-gray-900 { color: var(--color-gray-900); }
                .text-gray-950 { color: var(--color-gray-950); }
                
                .text-white { color: white; }
                .text-black { color: black; }
                .text-transparent { color: transparent; }
                
                /* Border Colors */
                .border-primary-100 { border-color: var(--color-primary-100); }
                .border-primary-200 { border-color: var(--color-primary-200); }
                .border-primary-300 { border-color: var(--color-primary-300); }
                .border-primary-500 { border-color: var(--color-primary-500); }
                .border-gray-100 { border-color: var(--color-gray-100); }
                .border-gray-200 { border-color: var(--color-gray-200); }
                .border-gray-300 { border-color: var(--color-gray-300); }
                .border-transparent { border-color: transparent; }
                
                /* Gradients */
                .bg-gradient-to-r { background-image: linear-gradient(to right, var(--tw-gradient-stops)); }
                .bg-gradient-to-br { background-image: linear-gradient(to bottom right, var(--tw-gradient-stops)); }
                .bg-gradient-to-tr { background-image: linear-gradient(to top right, var(--tw-gradient-stops)); }
                .bg-gradient-to-bl { background-image: linear-gradient(to bottom left, var(--tw-gradient-stops)); }
                
                .from-primary-500 { --tw-gradient-from: var(--color-primary-500); --tw-gradient-to: rgb(14 165 233 / 0); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
                .from-primary-600 { --tw-gradient-from: var(--color-primary-600); --tw-gradient-to: rgb(2 132 199 / 0); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
                .from-secondary-500 { --tw-gradient-from: var(--color-secondary-500); --tw-gradient-to: rgb(34 197 94 / 0); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
                .from-accent-500 { --tw-gradient-from: var(--color-accent-500); --tw-gradient-to: rgb(217 70 239 / 0); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
                
                .via-primary-400 { --tw-gradient-via: var(--color-primary-400); --tw-gradient-to: rgb(56 189 248 / 0); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-via), var(--tw-gradient-to); }
                .via-secondary-400 { --tw-gradient-via: var(--color-secondary-400); --tw-gradient-to: rgb(74 222 128 / 0); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-via), var(--tw-gradient-to); }
                
                .to-primary-700 { --tw-gradient-to: var(--color-primary-700); }
                .to-secondary-700 { --tw-gradient-to: var(--color-secondary-700); }
                .to-accent-700 { --tw-gradient-to: var(--color-accent-700); }
                
                /* Shadows */
                .shadow-sm { box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); }
                .shadow { box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); }
                .shadow-md { box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); }
                .shadow-lg { box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); }
                .shadow-xl { box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
                .shadow-2xl { box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25); }
                
                /* Effects */
                .opacity-0 { opacity: 0; }
                .opacity-25 { opacity: 0.25; }
                .opacity-50 { opacity: 0.5; }
                .opacity-75 { opacity: 0.75; }
                .opacity-100 { opacity: 1; }
                
                .backdrop-blur-sm { backdrop-filter: blur(4px); }
                .backdrop-blur-md { backdrop-filter: blur(8px); }
                .backdrop-blur-lg { backdrop-filter: blur(16px); }
                
                /* Transitions */
                .transition-all { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
                .transition-colors { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
                .transition-transform { transition-property: transform; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
                .transition-opacity { transition-property: opacity; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
                
                .duration-200 { transition-duration: 200ms; }
                .duration-300 { transition-duration: 300ms; }
                .duration-500 { transition-duration: 500ms; }
                
                .ease-in { transition-timing-function: cubic-bezier(0.4, 0, 1, 1); }
                .ease-out { transition-timing-function: cubic-bezier(0, 0, 0.2, 1); }
                .ease-in-out { transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
                
                /* Hover States */
                .hover\:bg-primary-600:hover { background-color: var(--color-primary-600); }
                .hover\:bg-secondary-600:hover { background-color: var(--color-secondary-600); }
                .hover\:bg-gray-100:hover { background-color: var(--color-gray-100); }
                
                .hover\:text-primary-600:hover { color: var(--color-primary-600); }
                .hover\:text-secondary-600:hover { color: var(--color-secondary-600); }
                
                .hover\:border-primary-300:hover { border-color: var(--color-primary-300); }
                .hover\:border-secondary-300:hover { border-color: var(--color-secondary-300); }
                
                .hover\:shadow-lg:hover { box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); }
                .hover\:shadow-xl:hover { box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
                
                .hover\:scale-105:hover { transform: scale(1.05); }
                .hover\:scale-110:hover { transform: scale(1.1); }
                
                /* Focus States */
                .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
                .focus\:ring-2:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
                .focus\:ring-primary-500:focus { --tw-ring-color: var(--color-primary-500); }
                .focus\:ring-secondary-500:focus { --tw-ring-color: var(--color-secondary-500); }
                .focus\:ring-offset-2:focus { --tw-ring-offset-width: 2px; }
                
                /* Dark Mode */
                @media (prefers-color-scheme: dark) {
                    .dark\:bg-gray-900 { background-color: var(--color-gray-900); }
                    .dark\:bg-gray-800 { background-color: var(--color-gray-800); }
                    .dark\:bg-gray-700 { background-color: var(--color-gray-700); }
                    
                    .dark\:text-gray-100 { color: var(--color-gray-100); }
                    .dark\:text-gray-200 { color: var(--color-gray-200); }
                    .dark\:text-gray-300 { color: var(--color-gray-300); }
                    
                    .dark\:border-gray-700 { border-color: var(--color-gray-700); }
                    .dark\:border-gray-600 { border-color: var(--color-gray-600); }
                    
                    .dark\:hover\:bg-gray-700:hover { background-color: var(--color-gray-700); }
                    .dark\:hover\:bg-gray-600:hover { background-color: var(--color-gray-600); }
                    
                    .dark\:bg-primary-900 { background-color: var(--color-primary-900); }
                    .dark\:text-primary-200 { color: var(--color-primary-200); }
                    .dark\:border-primary-700 { border-color: var(--color-primary-700); }
                }
                
                /* Responsive */
                @media (min-width: 640px) {
                    .sm\:flex-row { flex-direction: row; }
                    .sm\:w-auto { width: auto; }
                    .sm\:text-lg { font-size: 1.125rem; line-height: 1.75rem; }
                }
                
                @media (min-width: 768px) {
                    .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                    .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                    .md\:flex-row { flex-direction: row; }
                }
                
                @media (min-width: 1024px) {
                    .lg\:flex-row { flex-direction: row; }
                    .lg\:flex { display: flex; }
                    .lg\:hidden { display: none; }
                    .lg\:w-1\/2 { width: 50%; }
                    .lg\:w-2\/3 { width: 66.666667%; }
                    .lg\:max-w-4xl { max-width: 56rem; }
                    .lg\:max-w-6xl { max-width: 72rem; }
                    .lg\:p-8 { padding: 2rem; }
                    .lg\:p-12 { padding: 3rem; }
                }
            </style>
        @endif

        <style>
            /* Custom animations and effects */
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-15px); }
            }

            @keyframes pulse-glow {
                0%, 100% { opacity: 1; box-shadow: 0 0 20px rgba(0, 228, 255, 0.5); }
                50% { opacity: 0.8; box-shadow: 0 0 30px rgba(0, 228, 255, 0.8); }
            }

            @keyframes shimmer {
                0% { background-position: -200px 0; }
                100% { background-position: calc(200px + 100%) 0; }
            }

            @keyframes rainbow-glow {
                0%, 100% { box-shadow: 0 0 20px rgba(0, 228, 255, 0.5); }
                25% { box-shadow: 0 0 20px rgba(249, 115, 22, 0.5); }
                50% { box-shadow: 0 0 20px rgba(106, 187, 106, 0.5); }
                75% { box-shadow: 0 0 20px rgba(0, 228, 255, 0.5); }
            }

            @keyframes particle-float {
                0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.7; }
                50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
            }

            @keyframes gradient-shift {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }
            
            .animate-float {
                animation: float 4s ease-in-out infinite;
            }
            
            .animate-pulse-glow {
                animation: pulse-glow 2s ease-in-out infinite;
            }
            
            .animate-shimmer {
                background: linear-gradient(90deg, 
                    rgba(255, 255, 255, 0) 0%, 
                    rgba(255, 255, 255, 0.3) 50%, 
                    rgba(255, 255, 255, 0) 100%);
                background-size: 200px 100%;
                animation: shimmer 2s infinite;
            }
            
            .glass-effect {
                backdrop-filter: blur(12px);
                background: rgba(255, 255, 255, 0.15);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .dark .glass-effect {
                background: rgba(0, 0, 0, 0.25);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .card-hover {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }
            
            .gradient-border {
                position: relative;
                background: linear-gradient(white, white) padding-box,
                            linear-gradient(135deg, var(--color-primary-500), var(--color-secondary-500)) border-box;
                border: 2px solid transparent;
            }

            .dark .gradient-border {
                background: linear-gradient(var(--color-gray-800), var(--color-gray-800)) padding-box,
                            linear-gradient(135deg, var(--color-primary-500), var(--color-secondary-500)) border-box;
            }

            .tourism-gradient {
                background: linear-gradient(135deg, var(--color-ocean-500), var(--color-sunset-500), var(--color-forest-500));
            }
            
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: var(--color-gray-100);
            }
            
            ::-webkit-scrollbar-thumb {
                background: var(--color-primary-300);
                border-radius: 4px;
            }
            
            .dark ::-webkit-scrollbar-track {
                background: var(--color-gray-800);
            }
            
            .dark ::-webkit-scrollbar-thumb {
                background: var(--color-primary-600);
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-ocean-50 via-white to-sunset-50 dark:from-gray-900 dark:via-gray-800 dark:to-ocean-900 text-gray-800 dark:text-gray-200 flex flex-col items-center min-h-screen p-4 md:p-6 lg:p-8 relative overflow-hidden">
        <!-- Floating Particles Background -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-2 h-2 bg-ocean-400 rounded-full animate-particle-float opacity-60"></div>
            <div class="absolute top-40 right-20 w-3 h-3 bg-sunset-400 rounded-full animate-particle-float opacity-50" style="animation-delay: 1s;"></div>
            <div class="absolute top-60 left-1/4 w-2 h-2 bg-forest-400 rounded-full animate-particle-float opacity-70" style="animation-delay: 2s;"></div>
            <div class="absolute top-80 right-1/3 w-2.5 h-2.5 bg-ocean-500 rounded-full animate-particle-float opacity-40" style="animation-delay: 3s;"></div>
            <div class="absolute bottom-40 left-20 w-3 h-3 bg-sunset-500 rounded-full animate-particle-float opacity-50" style="animation-delay: 4s;"></div>
            <div class="absolute bottom-60 right-10 w-2 h-2 bg-forest-500 rounded-full animate-particle-float opacity-60" style="animation-delay: 5s;"></div>
            <div class="absolute top-1/3 left-3/4 w-2.5 h-2.5 bg-ocean-300 rounded-full animate-particle-float opacity-45" style="animation-delay: 6s;"></div>
            <div class="absolute bottom-1/3 right-1/4 w-2 h-2 bg-sunset-300 rounded-full animate-particle-float opacity-55" style="animation-delay: 7s;"></div>
        </div>

        <div class="w-full max-w-7xl relative z-10">
            <!-- Header -->
            <header class="w-full mb-8 lg:mb-12">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <!-- Logo -->
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="absolute inset-0 tourism-gradient rounded-xl animate-rainbow-glow"></div>
                            <div class="relative tourism-gradient p-3 rounded-xl shadow-lg">
                                <i class="fas fa-globe-asia text-white text-2xl"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-ocean-600 via-sunset-600 to-forest-600 bg-clip-text text-transparent">
                                Tourism Management System
                            </h1>
                            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 font-medium">Professional Tourism Solutions</p>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="flex items-center gap-4 md:gap-6">
                        <a href="#home" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">
                            <i class="fas fa-home mr-1"></i>Home
                        </a>
                        <a href="#about" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">
                            <i class="fas fa-info-circle mr-1"></i>About Us
                        </a>
                        <a href="#contact" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">
                            <i class="fas fa-envelope mr-1"></i>Contact
                        </a>

                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="group inline-flex items-center gap-2 px-5 py-3 bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 border border-gray-200 dark:border-gray-700 rounded-lg font-medium transition-all duration-300 hover:bg-primary-50 dark:hover:bg-gray-700 hover:border-primary-300 hover:shadow-md">
                                    <i class="fas fa-tachometer-alt text-primary-500 group-hover:scale-110 transition-transform"></i>
                                    <span>Dashboard</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="group inline-flex items-center gap-2 px-5 py-3 bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 border border-gray-200 dark:border-gray-700 rounded-lg font-medium transition-all duration-300 hover:bg-primary-50 dark:hover:bg-gray-700 hover:border-primary-300 hover:shadow-md">
                                    <i class="fas fa-sign-in-alt text-primary-500 group-hover:scale-110 transition-transform"></i>
                                    <span>Login</span>
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="group inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-lg font-semibold transition-all duration-300 hover:from-primary-600 hover:to-secondary-600 hover:shadow-lg hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                        <i class="fas fa-user-plus group-hover:rotate-12 transition-transform"></i>
                                        <span>Get Started</span>
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </nav>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex flex-col gap-8 lg:gap-12 relative">
                <!-- Subtle Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-ocean-50/20 via-transparent to-sunset-50/20 pointer-events-none rounded-3xl"></div>
                <!-- Hero Section (Home) -->
                <section id="home" class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                    <!-- Left Content Panel -->
                    <div class="flex-1">
                        <div class="gradient-border rounded-2xl p-6 md:p-8 lg:p-10 bg-white dark:bg-gray-800 shadow-xl">
                        <!-- Hero Section -->
                        <div class="mb-8 lg:mb-12">
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 rounded-full text-sm font-semibold mb-4">
                                <i class="fas fa-star text-primary-500"></i>
                                <span>Leading Tourism Platform</span>
                            </div>
                            
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                                Transform Tourism Experiences with 
                                <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">Intelligent Management</span>
                            </h1>
                            
                            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                                Streamline your tourism operations with our comprehensive platform. Manage destinations, bookings, and customer experiences all in one place.
                            </p>
                        </div>

                        <!-- Features Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                            <!-- Destination Management -->
                            <div class="card-hover group bg-gradient-to-br from-white to-primary-50 dark:from-gray-800 dark:to-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-tr from-primary-500 to-secondary-500 rounded-lg opacity-20 group-hover:opacity-30 transition-opacity"></div>
                                        <div class="relative bg-gradient-to-tr from-primary-500 to-secondary-500 p-3 rounded-lg">
                                            <i class="fas fa-map-marked-alt text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Destination Management</h3>
                                        <p class="text-gray-600 dark:text-gray-300">Curate and manage stunning destinations with rich multimedia content and real-time analytics.</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-primary-600 dark:text-primary-400 font-medium mt-4">
                                    <span>Explore Features</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>

                            <!-- Booking System -->
                            <div class="card-hover group bg-gradient-to-br from-white to-secondary-50 dark:from-gray-800 dark:to-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-tr from-secondary-500 to-accent-500 rounded-lg opacity-20 group-hover:opacity-30 transition-opacity"></div>
                                        <div class="relative bg-gradient-to-tr from-secondary-500 to-accent-500 p-3 rounded-lg">
                                            <i class="fas fa-calendar-check text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Smart Booking</h3>
                                        <p class="text-gray-600 dark:text-gray-300">Automated booking system with real-time availability and instant confirmation notifications.</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-secondary-600 dark:text-secondary-400 font-medium mt-4">
                                    <span>Book Now</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Start Guide -->
                        <div class="mb-10">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Start Your Journey in 3 Steps</h2>
                            <div class="space-y-4">
                                <!-- Step 1 -->
                                <div class="group flex items-center gap-4 p-5 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:border-primary-200 dark:hover:border-primary-700 transition-all duration-300">
                                    <div class="flex-shrink-0">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-gradient-to-tr from-primary-500 to-secondary-500 rounded-full animate-pulse"></div>
                                            <div class="relative bg-gradient-to-tr from-primary-600 to-secondary-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg">
                                                1
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 dark:text-white">Create Your Account</h4>
                                        <p class="text-gray-600 dark:text-gray-300">Sign up in minutes and get instant access to all features.</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-primary-500 group-hover:translate-x-1 transition-transform"></i>
                                </div>

                                <!-- Step 2 -->
                                <div class="group flex items-center gap-4 p-5 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-secondary-50 dark:hover:bg-secondary-900/20 hover:border-secondary-200 dark:hover:border-secondary-700 transition-all duration-300">
                                    <div class="flex-shrink-0">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-gradient-to-tr from-secondary-500 to-accent-500 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                                            <div class="relative bg-gradient-to-tr from-secondary-600 to-accent-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg">
                                                2
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 dark:text-white">Explore Destinations</h4>
                                        <p class="text-gray-600 dark:text-gray-300">Browse through thousands of curated tourism locations worldwide.</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-secondary-500 group-hover:translate-x-1 transition-transform"></i>
                                </div>

                                <!-- Step 3 -->
                                <div class="group flex items-center gap-4 p-5 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-accent-50 dark:hover:bg-accent-900/20 hover:border-accent-200 dark:hover:border-accent-700 transition-all duration-300">
                                    <div class="flex-shrink-0">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-gradient-to-tr from-accent-500 to-primary-500 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                                            <div class="relative bg-gradient-to-tr from-accent-600 to-primary-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg">
                                                3
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 dark:text-white">Manage & Grow</h4>
                                        <p class="text-gray-600 dark:text-gray-300">Handle bookings, analyze performance, and scale your tourism business.</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-accent-500 group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('register') }}"
                               class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-ocean-500 via-sunset-500 to-forest-500 text-white rounded-xl font-semibold transition-all duration-300 hover:from-ocean-600 hover:via-sunset-600 hover:to-forest-600 hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:ring-offset-2">
                                <i class="fas fa-rocket group-hover:rotate-12 transition-transform"></i>
                                <span>Start Free Trial</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            
                            <a href="#" 
                               class="group inline-flex items-center gap-3 px-8 py-4 bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 border-2 border-primary-200 dark:border-primary-700 rounded-xl font-semibold transition-all duration-300 hover:bg-primary-50 dark:hover:bg-gray-700 hover:border-primary-300 hover:shadow-lg">
                                <i class="fas fa-play-circle text-primary-500"></i>
                                <span>Watch Demo</span>
                                <i class="fas fa-external-link-alt text-sm group-hover:scale-110 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Visual Panel -->
                <div class="lg:w-2/5">
                    <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                        <!-- Main Gradient Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-ocean-600 via-sunset-500 to-forest-500"></div>
                        
                        <!-- Animated Background Elements -->
                        <div class="absolute top-1/4 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
                        <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
                        
                        <!-- Floating Icons -->
                        <div class="absolute top-8 right-8 w-16 h-16 bg-white/20 rounded-full animate-float" style="animation-delay: 0.3s;"></div>
                        <div class="absolute bottom-8 left-8 w-12 h-12 bg-white/15 rounded-full animate-float" style="animation-delay: 0.7s;"></div>
                        
                        <!-- Content Container -->
                        <div class="relative z-10 p-8 lg:p-10 h-full">
                            <div class="mb-8">
                                <h2 class="text-3xl font-bold text-white mb-4">Discover the World</h2>
                                <p class="text-white/90 text-lg">Join 50,000+ tourism professionals revolutionizing their business with TourismHub.</p>
                            </div>
                            
                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="glass-effect p-4 rounded-xl">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-white mb-1">1,200+</div>
                                        <div class="text-white/80 text-sm">Destinations</div>
                                    </div>
                                </div>
                                <div class="glass-effect p-4 rounded-xl">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-white mb-1">50K+</div>
                                        <div class="text-white/80 text-sm">Travelers</div>
                                    </div>
                                </div>
                                <div class="glass-effect p-4 rounded-xl">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-white mb-1">98.5%</div>
                                        <div class="text-white/80 text-sm">Satisfaction</div>
                                    </div>
                                </div>
                                <div class="glass-effect p-4 rounded-xl">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-white mb-1">24/7</div>
                                        <div class="text-white/80 text-sm">Support</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Features List -->
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center gap-3 text-white">
                                    <div class="bg-white/20 p-2 rounded-lg">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                    <span class="font-medium">Real-time availability tracking</span>
                                </div>
                                <div class="flex items-center gap-3 text-white">
                                    <div class="bg-white/20 p-2 rounded-lg">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                    <span class="font-medium">Automated booking confirmations</span>
                                </div>
                                <div class="flex items-center gap-3 text-white">
                                    <div class="bg-white/20 p-2 rounded-lg">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                    <span class="font-medium">Multilingual support</span>
                                </div>
                                <div class="flex items-center gap-3 text-white">
                                    <div class="bg-white/20 p-2 rounded-lg">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                    <span class="font-medium">Advanced analytics dashboard</span>
                                </div>
                            </div>
                            
                            <!-- Testimonial -->
                            <div class="glass-effect p-5 rounded-xl">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white">Maria Rodriguez</div>
                                        <div class="text-white/70 text-sm">Tour Agency Owner</div>
                                    </div>
                                </div>
                                <p class="text-white/90 italic">"TourismHub transformed our operations. Bookings increased by 200% in just 3 months!"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start gap-3 mb-3">
                            <div class="bg-gradient-to-tr from-primary-500 to-secondary-500 p-2 rounded-lg">
                                <i class="fas fa-globe-asia text-white text-lg"></i>
                            </div>
                            <span class="text-xl font-bold text-gray-900 dark:text-white">Tourism Management System</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">© {{ date('Y') }} Tourism Management System. All rights reserved. Professional tourism solutions.</p>
                    </div>
                    
                    <div class="flex items-center gap-6">
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            <i class="fab fa-facebook text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            <i class="fab fa-linkedin text-lg"></i>
                        </a>
                    </div>
                </div>
                
                <div class="mt-6 text-center text-gray-500 dark:text-gray-500 text-sm">
                    <p>Built with ❤️ for the tourism industry worldwide</p>
                </div>
            </footer>
        </div>

        <!-- Script for interactive elements -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add hover effect to cards
                const cards = document.querySelectorAll('.card-hover');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        card.style.transform = 'translateY(-8px)';
                    });
                    card.addEventListener('mouseleave', () => {
                        card.style.transform = 'translateY(0)';
                    });
                });

                // Smooth scroll for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });

                // Add loading animation
                const mainContent = document.querySelector('main');
                mainContent.style.opacity = '0';
                mainContent.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    mainContent.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    mainContent.style.opacity = '1';
                    mainContent.style.transform = 'translateY(0)';
                }, 300);
            });
        </script>
    </body>
</html>