<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Artikel Wisata') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">

    <div class="min-h-screen flex">

        {{-- Sisi kiri: ilustrasi / branding --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-600 to-wisata-teal flex-col justify-center items-center p-12 text-white">
            <a href="{{ route('home') }}" class="flex items-center gap-3 mb-8">
                <span class="text-5xl">🌏</span>
                <span class="text-3xl font-bold">Artikel Wisata</span>
            </a>
            <p class="text-center text-primary-100 text-lg leading-relaxed max-w-sm">
                Jelajahi keindahan destinasi wisata nusantara. Pantai, gunung, sejarah, kuliner — semua ada di sini.
            </p>
            <div class="mt-10 grid grid-cols-2 gap-4 text-center">
                <div class="bg-white/10 rounded-xl p-4">
                    <div class="text-3xl mb-1">🏖️</div>
                    <div class="text-sm font-medium">Pantai</div>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <div class="text-3xl mb-1">🏔️</div>
                    <div class="text-sm font-medium">Gunung</div>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <div class="text-3xl mb-1">🏛️</div>
                    <div class="text-sm font-medium">Sejarah</div>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <div class="text-3xl mb-1">🍜</div>
                    <div class="text-sm font-medium">Kuliner</div>
                </div>
            </div>
        </div>

        {{-- Sisi kanan: form --}}
        <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50">
            {{-- Logo mobile --}}
            <a href="{{ route('home') }}" class="lg:hidden flex items-center gap-2 text-primary-600 font-bold text-xl mb-8">
                <span class="text-3xl">🌏</span>
                <span>Artikel Wisata</span>
            </a>

            <div class="w-full max-w-md">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-8">
                    {{ $slot }}
                </div>
                <p class="text-center text-xs text-gray-400 mt-4">
                    &copy; {{ date('Y') }} Artikel Wisata
                </p>
            </div>
        </div>
    </div>

</body>
</html>
