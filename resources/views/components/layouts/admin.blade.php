<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin - FoodLoop' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        h1, h2, h3, .brand-font {
            font-family: 'Manrope', sans-serif;
        }

        ::selection {
            background: #E9A17D;
            color: #4A342B;
        }
    </style>
</head>

<body class="min-h-screen bg-[#FFF8F2] text-[#4A342B] antialiased">

    <div class="min-h-screen">

        <header class="sticky top-0 z-40 border-b border-[#EAD8CD] bg-white/95 backdrop-blur">
            <div class="flex h-16 items-center justify-between px-5 sm:px-8">

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#4A342B] text-lg font-extrabold text-[#E9A17D]">
                        F
                    </span>

                    <span>
                        <span class="brand-font block text-base font-extrabold text-[#4A342B]">
                            FoodLoop
                        </span>
                        <span class="block text-[10px] font-bold uppercase tracking-[0.18em] text-[#A18F84]">
                            Administration
                        </span>
                    </span>
                </a>

                <div class="flex items-center gap-3 sm:gap-5">

                    <a href="{{ route('welcome') }}"
                       class="hidden items-center gap-2 text-sm font-semibold text-[#806F66] transition hover:text-[#B96F4D] sm:flex">
                        <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" />
                        View website
                    </a>

                    <div class="hidden h-8 w-px bg-[#EAD8CD] sm:block"></div>

                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-bold text-[#4A342B]">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-[#A18F84]">Administrator</p>
                        </div>

                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#F7E8DE] text-sm font-extrabold text-[#8E583D]">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>

                </div>
            </div>
        </header>

        <div class="flex min-h-[calc(100vh-4rem)] flex-col lg:flex-row">

            <x-admin-sidebar />

            <main class="min-w-0 flex-1">

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('organization') || $errors->has('listing') || $errors->has('category'))
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                        {{ $errors->first('organization') ?: $errors->first('listing') ?: $errors->first('category') }}
                    </div>
                @endif

                {{ $slot }}

            </main>
        </div>

    </div>

</body>
</html>
