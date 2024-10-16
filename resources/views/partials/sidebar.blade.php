<nav class=" relative flex bg-gradient-to-b from-gray-800 to-gray-900 text-white w-64 min-h-screen px-4 py-6 flex flex-col justify-between shadow-lg transition-all duration-300 ease-in-out" x-data="{ isOpen: true }">
    <div>
        <div class="mb-8 text-center" x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
            <h1 class="text-2xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 animate-pulse">Dashboard</h1>
            <h2 class="text-xl font-bold mb-3 text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">API SMS</h2>
            <p class="text-sm text-gray-300 mt-1">Bienvenue, <span class="font-semibold text-yellow-300">{{ Auth::user()->name }}</span></p>
        </div>
        <ul class="space-y-3" x-data="{ activeItem: 'dashboard' }">
            <li>
                <a href="{{ route('dashboard') }}" @click="activeItem = 'dashboard'" :class="{ 'bg-gray-700 text-white': activeItem === 'dashboard' }" class="flex items-center text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg p-2 transition duration-200 group">
                    <svg class="w-6 h-6 mr-3 text-blue-400 group-hover:text-blue-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium" x-show="isOpen">Tableau de bord</span>
                </a>
            </li>
            <li>
                <a href="https://smspro.cm/" target="_blank" rel="noopener noreferrer" @click="activeItem = 'send'" :class="{ 'bg-gray-700 text-white': activeItem === 'send' }" class="flex items-center text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg p-2 transition duration-200 group">
                    <svg class="w-6 h-6 mr-3 text-green-400 group-hover:text-green-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <span class="font-medium" x-show="isOpen">Envoyer SMS</span>
                </a>
            </li>
            <li>
                <a href="" @click="activeItem = 'history'" :class="{ 'bg-gray-700 text-white': activeItem === 'history' }" class="flex items-center text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg p-2 transition duration-200 group">
                    <svg class="w-6 h-6 mr-3 text-purple-400 group-hover:text-purple-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span class="font-medium" x-show="isOpen">Historique</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="mt-auto">
        <hr class="my-4 border-gray-600">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard.developer') }}" @click="activeItem = 'developer'" :class="{ 'bg-gray-700 text-white': activeItem === 'developer' }" class="flex items-center text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg p-2 transition duration-200 group">
                    <svg class="w-5 h-5 mr-3 text-yellow-400 group-hover:text-yellow-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    <span class="font-medium" x-show="isOpen">Developer</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.solde') }}" @click="activeItem = 'solde'" :class="{ 'bg-gray-700 text-white': activeItem === 'solde' }" class="flex items-center text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg p-2 transition duration-200 group">
                    <svg class="w-5 h-5 mr-3 text-green-400 group-hover:text-green-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span class="font-medium" x-show="isOpen">Soldes</span>
                </a>
            </li>
            <li>
                <a href="#" @click="activeItem = 'settings'" :class="{ 'bg-gray-700 text-white': activeItem === 'settings' }" class="flex items-center text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg p-2 transition duration-200 group">
                    <svg class="w-5 h-5 mr-3 text-pink-400 group-hover:text-pink-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium" x-show="isOpen">Paramètres</span>
                </a>
            </li>
        </ul>
    </div>
    <button aria-label="Toggle Sidebar" @click="isOpen = !isOpen" class="absolute top-4 -right-3 bg-gray-800 text-white p-1 rounded-full shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white transition-all duration-200 transform hover:scale-110">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-show="isOpen">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-show="!isOpen">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
</nav>