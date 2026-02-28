<x-guest-layout>
    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- LEFT SIDE -->
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-purple-600 to-indigo-900 p-8 flex-col justify-between relative overflow-hidden">
            
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply blur-3xl opacity-20"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply blur-3xl opacity-20"></div>
            </div>

            <div class="relative">
                <a href="/" class="text-white text-2xl font-bold flex items-center">
                    <svg class="w-8 h-8 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    YourApp
                </a>
            </div>

            <div class="relative text-white max-w-md">
                <h1 class="text-4xl font-bold mb-6">Join Our Community</h1>
                <p class="text-lg opacity-90 mb-8">
                    Create your account and start your journey with us.
                </p>
            </div>

            <div class="relative text-white opacity-80 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold underline hover:text-white">
                    Sign in here
                </a>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-6 bg-gradient-to-b from-gray-50 to-white">
            <div class="w-full max-w-lg">

                <div class="bg-white rounded-2xl shadow-xl p-8">

                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800">Create Account</h2>
                        <p class="text-gray-600 mt-2">Fill in your details</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- NAME -->
                        <div>
                            <x-input-label for="name" value="Full Name" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400"
                                        fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>

                                <x-text-input id="name" name="name" type="text"
                                    class="pl-10 w-full py-3 rounded-xl border-gray-300 focus:ring-purple-500 focus:border-purple-500"
                                    :value="old('name')" required autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <x-input-label for="email" value="Email Address" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400"
                                        fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>

                                <x-text-input id="email" name="email" type="email"
                                    class="pl-10 w-full py-3 rounded-xl border-gray-300 focus:ring-purple-500 focus:border-purple-500"
                                    :value="old('email')" required />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <x-input-label for="password" value="Password" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400"
                                        fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>

                                <x-text-input id="password" name="password" type="password"
                                    class="pl-10 w-full py-3 rounded-xl border-gray-300 focus:ring-purple-500 focus:border-purple-500"
                                    required />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div>
                            <x-input-label for="password_confirmation" value="Confirm Password" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400"
                                        fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12l2 2 4-4"/>
                                    </svg>
                                </div>

                                <x-text-input id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    class="pl-10 w-full py-3 rounded-xl border-gray-300 focus:ring-purple-500 focus:border-purple-500"
                                    required />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- SUBMIT -->
                        <div class="pt-4">
                            <x-primary-button class="w-full justify-center py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700">
                                Create Account
                            </x-primary-button>
                        </div>

                        <div class="text-center text-sm text-gray-600 pt-4">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:text-purple-500">
                                Sign in
                            </a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>