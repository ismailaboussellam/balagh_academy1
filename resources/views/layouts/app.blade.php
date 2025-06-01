<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- خطوط وأيقونات -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- ستايل إضافي للـ body -->
        <style>
            body {
                @if (auth()->check())
                    @if (auth()->user()->role === 'student')
                        background: linear-gradient(135deg, #f0f9ff 0%, #e6fffa 100%);
                    @elseif (auth()->user()->role === 'teacher')
                        background: linear-gradient(135deg, #e0e7ff 0%, #f0fdf4 100%);
                    @else
                        background: linear-gradient(135deg, #f3f4f6 0%, #ffffff 100%);
                    @endif
                @else
                    background: linear-gradient(135deg, #f3f4f6 0%, #ffffff 100%);
                @endif
                min-height: 100vh;
            }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- استدعاء واحد فقط -->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col">
            <!-- Include Navigation without try-catch -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 dark:bg-gray-800/80 shadow-lg rounded-b-xl mb-4">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6">
                    {{ $slot }}
                </div>
            </main>
            <footer class="text-center text-xs text-gray-400 py-4">
                © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. جميع الحقوق محفوظة.
            </footer>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts') 
    </body>
</html>
