<!-- partials/modal.blade.php -->
<div id="apiKeyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded-lg max-w-sm w-full">
        <h2 class="text-lg font-semibold mb-4">{{ $title ?? 'Title' }}</h2>
        <!-- Affiche le contenu passé dans le slot ici -->
        <div>
            {{ $slot }}
        </div>
        <button type="button" onclick="closeApiKeyModal()" class="text-gray-600 hover:underline mt-4">Cancel</button>
    </div>
</div>
