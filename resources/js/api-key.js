// Gérer les onglets actifs
function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
    document.querySelectorAll('.tab-link').forEach(link => link.classList.remove('border-blue-500', 'text-blue-500'));

    document.getElementById(tabId).classList.remove('hidden');
    document.getElementById('tab-' + tabId).classList.add('border-blue-500', 'text-blue-500');
}

// Afficher le premier onglet au chargement
document.addEventListener('DOMContentLoaded', function() {
    showTab('overview'); // Définit l'onglet 'Overview' comme actif par défaut
});

// Soumettre le formulaire pour générer la clé API
async function submitApiKeyForm() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('/generate-api-key', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ email, password })
        });

        const result = await response.json();
        if (response.ok) {
            const apiKeyElement = document.getElementById('apiKey');
            apiKeyElement.innerText = result.api_key;
            document.getElementById('apiKeySection').innerHTML = `
                <div class="relative p-4 bg-gray-100 rounded-lg">
                    <span id="apiKey" class="font-mono text-sm text-gray-700">${result.api_key}</span>
                    <button onclick="copyApiKey()" class="absolute right-4 top-4 text-blue-600 hover:underline">Copy</button>
                    <button onclick="openApiKeyModal()" class="absolute right-20 top-4 text-blue-600 hover:underline">Regenerate</button>
                </div>
            `;
            alert("API Key generated: " + result.api_key);
            closeApiKeyModal();
        } else {
            alert("Error: " + result.error);
        }
    } catch (error) {
        console.error("Error generating API key:", error);
    }
}

// Copier la clé API
function copyApiKey() {
    const apiKey = document.getElementById("apiKey").innerText;
    navigator.clipboard.writeText(apiKey).then(() => {
        alert("API Key copied!");
    });
}

// Afficher le premier onglet au chargement
document.addEventListener('DOMContentLoaded', function() {
    showTab('overview');
});
