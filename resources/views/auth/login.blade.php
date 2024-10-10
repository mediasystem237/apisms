<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-md mx-auto bg-gray-100 shadow-md rounded-lg overflow-hidden mt-10">
        <div class="px-6 py-4">
            <h2 class="text-2xl font-bold text-center text-gray-900">Connexion</h2>
            <p class="text-center text-gray-600">Veuillez entrer vos informations de connexion.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Lien vers la page d'inscription -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    {{ __("Vous n'avez pas de compte ?") }}
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-900">
                        {{ __('Créez-en un ici.') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
