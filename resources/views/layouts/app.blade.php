<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard API')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js (latest) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="h-full bg-gray-100 dark:bg-gray-900">
    <div id="toast-container" class="fixed bottom-4 right-4 space-y-2"></div>

    <div class="flex h-full">
        @include('partials.sidebar')
        
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @include('partials.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="hidden fixed bg-green-500 text-white p-3 rounded shadow-lg transition-opacity duration-300">
        API Key copiée avec succès
    </div>

    <!-- Theme Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Initial theme setup
            const currentTheme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', currentTheme === 'dark');
            themeToggleLightIcon.classList.toggle('hidden', currentTheme === 'dark');
            themeToggleDarkIcon.classList.toggle('hidden', currentTheme === 'light');

            // Toggle theme button click event
            themeToggleBtn.addEventListener('click', () => {
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                document.documentElement.classList.toggle('dark', newTheme === 'dark');
                localStorage.setItem('theme', newTheme);
                themeToggleLightIcon.classList.toggle('hidden', newTheme === 'dark');
                themeToggleDarkIcon.classList.toggle('hidden', newTheme === 'light');
            });
        });
    </script>
</body>
@yield('scripts')
</html>
