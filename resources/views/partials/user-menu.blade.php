<div class="flex items-center space-x-4">
    <!-- Thème Toggle -->
    <button id="theme-toggle" @click="toggleTheme" class="text-gray-500 dark:text-gray-400 p-2 rounded-lg focus:outline-none transition-colors duration-200">
        <svg x-show="!isDark" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 3a7 7 0 100 14 7 7 0 000-14zm0 12a5 5 0 110-10 5 5 0 010 10z" />
        </svg>
        <svg x-show="isDark" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
        </svg>
    </button>

    <!-- User Menu -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center space-x-2 rounded-full focus:outline-none">
            <svg class="h-8 w-8 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 1a9 9 0 100 18 9 9 0 000-18zM10 4a4 4 0 110 8 4 4 0 010-8zm0 10a8 8 0 00-6.32 3.08A6.99 6.99 0 0110 18a6.99 6.99 0 016.32-3.08A8 8 0 0010 14z" clip-rule="evenodd" />
            </svg>
            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 shadow-md rounded-md py-1">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200">Votre Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200">Se déconnecter</button>
            </form>
        </div>
    </div>
</div>
