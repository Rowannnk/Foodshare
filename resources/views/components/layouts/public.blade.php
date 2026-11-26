<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'FoodLoop') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif

    <style>
        :root {
            --foodloop-orange: #E9A17D;
            --foodloop-orange-hover: #D98E69;
            --foodloop-brown: #4A342B;
            --foodloop-brown-light: #765748;
            --foodloop-cream: #FFF8F2;
            --foodloop-peach: #F1D8C8;
            --foodloop-muted: #88766D;
            --foodloop-border: #EAD8CD;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

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

        summary::-webkit-details-marker {
            display: none;
        }
    </style>
</head>

<body class="bg-[#FFF8F2] text-[#4A342B] antialiased">

    @include('layouts.public_navigation')

    @if (session('success'))
        <div class="mx-auto mt-6 max-w-7xl px-6 lg:px-8">
            <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-20 bg-[#4A342B] text-white">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
            <div class="grid gap-10 md:grid-cols-2">
                <div>
                    <a href="{{ route('welcome') }}" class="inline-flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E9A17D] text-xl font-extrabold text-[#4A342B]">
                            F
                        </span>

                        <span class="brand-font text-2xl font-extrabold">
                            FoodLoop
                        </span>
                    </a>

                    <p class="mt-5 max-w-md text-sm leading-7 text-white/65">
                        Making good food go further. Connecting food businesses
                        with communities to reduce waste and share more meals.
                    </p>
                </div>

                <div class="md:text-right">
                    <p class="font-semibold text-[#E9A17D]">
                        A little food can make a big difference.
                    </p>

                    <p class="mt-3 text-sm leading-7 text-white/60">
                        Join the movement and help build a community where
                        good food never goes to waste.
                    </p>
                </div>
            </div>

            <div class="mt-12 flex flex-col justify-between gap-4 border-t border-white/15 pt-6 text-xs text-white/50 sm:flex-row">
                <p>&copy; {{ date('Y') }} FoodLoop. All rights reserved.</p>
                <p>Less waste. More meals. Stronger communities.</p>
            </div>
        </div>
    </footer>

</body>
</html>
