@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Developer</h1>
    </div>

    <!-- Onglets horizontaux -->
    @include('partials.tabs')

    <div class="flex">
    <div class="w-2/3 pr-8">
    <!-- Contenu de l'onglet API Keys -->
    <div id="apiKeys" class="tab-content hidden api-key-container">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">API Key</h2>
        <p class="text-gray-600 mb-6">Manage your API key for accessing the platform.</p>

        <div class="bg-white border rounded-lg shadow-sm p-6 mb-4">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <span class="bg-yellow-300 rounded-full h-3 w-3"></span>
                    <h2 class="text-lg font-semibold text-gray-800">Your API Key</h2>
                </div>
                <!-- Eye icon for toggling visibility -->
                <button id="toggleApiKey" type="button" class="text-gray-500 focus:outline-none" onclick="toggleApiKeyVisibility()">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
            </div>
            <div class="bg-gray-50 rounded-md p-3 border border-gray-200">
                <input id="apiKeyInput" type="password" class="text-sm text-gray-800 font-mono break-all w-full border-none bg-transparent p-2"
                    value="{{ $apiKey->api_key ?? 'No key generated' }}" readonly>
            </div>
            <!-- Boutons sous la clé API -->
            <div class="flex mt-4 space-x-4">
                @if ($apiKey)
                    <button id="copyButton" onclick="copyApiKey()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Copy
                    </button>
                    <button id="revokeApiKeyButton" onclick="revokeApiKey()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Revoke API Key
                    </button>
                @else
                    <button id="generateButton" onclick="openApiKeyModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" 
                            {{ $apiKey ? 'hidden' : '' }}>
                        Generate
                    </button>
                @endif
            </div>
        </div>
    </div>
    <!-- Contenu de l'onglet Overview -->
    <div id="overview" class="tab-content">
        @include('partials.overview', ['apiLogs' => $apiLogs])
    </div>
</div>

        <!-- Sidebar -->
        <div class="w-1/3">
            @include('partials.devsidebar')
        </div>
    </div>
</div>

@component('partials.modal', ['title' => 'Generate API Key'])
    @slot('slot')
        <form id="generateApiKeyForm" class="bg-white p-6 rounded-lg shadow-md mb-4">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Générer votre clé API</h2>
            <p class="text-gray-600 mb-4">Veuillez renseigner vos informations de connexion pour SMSPro.cm afin de créer votre clé API.</p>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            
            <button type="button" onclick="submitApiKeyForm()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Générer</button>
        </form>

    @endslot
@endcomponent

<script src="{{ asset('js/api-key.js') }}"></script>

<!-- JavaScript for toggling visibility
 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggleApiKey');
        const apiKeyInput = document.getElementById('apiKeyInput');
        const eyeIcon = document.getElementById('eyeIcon');

        toggleButton.addEventListener('click', function() {
            // Toggle visibility
            if (apiKeyInput.type === 'text') {
                apiKeyInput.type = 'password'; // Change to password to hide the key
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                apiKeyInput.type = 'text'; // Change to text to show the key
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    });
</script>

-->

@endsection
