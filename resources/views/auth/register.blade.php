<x-guest-layout>
    <x-slot name="title">Create Account — Wanderlust</x-slot>

    {{-- Header --}}
    <div class="text-center mb-7">
        <h1 class="font-display font-bold text-2xl text-gray-900 mb-1">Join Wanderlust</h1>
        <p class="text-sm text-gray-500">Create your free account and start exploring</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                Full Name
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   required autofocus autocomplete="name"
                   placeholder="Your full name"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent transition
                          @error('name') border-red-300 bg-red-50 @enderror">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                Email Address
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autocomplete="username"
                   placeholder="you@example.com"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent transition
                          @error('email') border-red-300 bg-red-50 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                Password
            </label>
            <div class="relative" x-data="{ show: false }">
                <input id="password" :type="show ? 'text' : 'password'" name="password"
                       required autocomplete="new-password"
                       placeholder="Min. 8 characters"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 pr-10 text-sm text-gray-800 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent transition
                              @error('password') border-red-300 bg-red-50 @enderror">
                <button type="button" @click="show = !show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                Confirm Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   required autocomplete="new-password"
                   placeholder="Repeat your password"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent transition
                          @error('password_confirmation') border-red-300 bg-red-50 @enderror">
            @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3.5 rounded-xl text-sm transition-colors shadow-sm mt-2">
            Create Account →
        </button>

        {{-- Divider --}}
        <div class="flex items-center gap-3">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-xs text-gray-400">or</span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>

        {{-- Login link --}}
        <p class="text-center text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}"
               class="text-sky-500 font-semibold hover:text-sky-600 transition-colors">
                Sign in
            </a>
        </p>
    </form>
</x-guest-layout>
