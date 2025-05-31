<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- AOS Animations -->
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">


<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>

<!-- Your app CSS -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">



<style>
    body {
            font-family: 'Tajawal', sans-serif;
            direction: rtl;
            text-align: right;
        }

</style>
<script src="https://cdn.tailwindcss.com"></script>
</head>
    <body class="font-sans antialiased text-right rtl">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('partials.navbar')
            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            @include('partials.footer')
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts') 

    </body>
</html>
