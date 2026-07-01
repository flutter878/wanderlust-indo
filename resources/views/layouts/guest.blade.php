<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Wanderlust') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-display { font-family: 'Playfair Display', serif; }
        .font-body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-body antialiased">

    {{-- Full-page background dengan blur --}}
    <div class="min-h-screen relative flex items-center justify-center p-4 overflow-hidden">

        {{-- Background image --}}
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80')">
        </div>
        {{-- Blur + dark overlay --}}
        <div class="absolute inset-0 backdrop-blur-sm bg-black/40"></div>

        {{-- Form Card --}}
        <div class="relative z-10 w-full max-w-md">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="{{ route('home') }}"
                   class="font-display font-bold text-3xl text-white tracking-wide">
                    Wanderlust
                </a>
            </div>

            {{-- Card --}}
            <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl px-8 py-8">
                {{ $slot }}
            </div>

            <p class="text-center text-xs text-white/50 mt-6">
                &copy; {{ date('Y') }} Wanderlust Editorial. All rights reserved.
            </p>
        </div>
    </div>

</body>
</html>
