<x-guest-layout>
    <x-slot name="title">Sign In — Wanderlust</x-slot>

    {{-- Header --}}
    <div class="text-center mb-7">
        <h1 class="font-display font-bold text-2xl text-gray-900 mb-1">Welcome Back</h1>
        <p class="text-sm text-gray-500">Log in to your Wanderlust account</p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4 text-sm text-green-600 bg-green-50 rounded-xl px-4 py-2" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                Email Address
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
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
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs text-sky-500 hover:text-sky-600 transition-colors">
                        Forgot Password?
                    </a>
                @endif
            </div>
            <div class="relative" x-data="{ show: false }">
                <input id="password" :type="show ? 'text' : 'password'" name="password"
                       required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 pr-10 text-sm text-gray-800 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent transition
                              @error('password') border-red-300 bg-red-50 @enderror">
                <button type="button" @click="show = !show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="!show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember"
                       class="w-4 h-4 rounded border-gray-300 text-sky-500 focus:ring-sky-400">
                <span class="text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3.5 rounded-xl text-sm transition-colors shadow-sm mt-2">
            Sign in →
        </button>

        {{-- Divider --}}
        <div class="flex items-center gap-3 my-2">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-xs text-gray-400">or</span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>

        {{-- Register link --}}
        <p class="text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}"
               class="text-sky-500 font-semibold hover:text-sky-600 transition-colors">
                Sign up
            </a>
        </p>
    </form>
</x-guest-layout>
