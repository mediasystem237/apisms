// Fonction pour ouvrir la modale d'API Key
function openApiKeyModal() {
    const modal = document.getElementById('apiKeyModal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

// Fonction pour fermer la modale d'API Key
function closeApiKeyModal() {
    const modal = document.getElementById('apiKeyModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Fonction pour soumettre le formulaire et générer la clé API
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
            // Mettre à jour l'affichage de la clé API avec la nouvelle clé générée
            updateApiKeyDisplay(result.api_key);
            showToast("API Key generated successfully!", document.querySelector('#generateButton'));
            closeApiKeyModal();
        } else {
            showToast("Error: " + (result.error || "Unable to generate API Key"));
        }
    } catch (error) {
        console.error("Error generating API key:", error);
        showToast("An error occurred. Please try again.");
    }
}

// Fonction pour mettre à jour l'affichage de la clé API
function updateApiKeyDisplay(apiKey) {
    const apiKeySection = document.getElementById('apiKeySection');
    if (apiKeySection) {
        apiKeySection.innerHTML = `
            <div class="relative p-4 bg-gray-100 rounded-lg">
                <span id="apiKey" class="font-mono text-sm text-gray-700">${apiKey}</span>
                <button onclick="copyApiKey()" class="absolute right-4 top-4 text-blue-600 hover:underline">Copy</button>
                <button onclick="openApiKeyModal()" class="absolute right-20 top-4 text-blue-600 hover:underline">Regenerate</button>
            </div>
        `;
    }
}

function revokeApiKey() {
    const apiKeyInput = document.getElementById('apiKeyInput');
    if (!apiKeyInput) {
        console.error('API Key element not found!');
        return;
    }

    // Assurez-vous de récupérer la clé API ici
    const apiKey = apiKeyInput.value; // Utilisez la valeur du champ d'entrée

    // Logique pour révoquer la clé API
    // Par exemple, vous pourriez faire une requête AJAX ici
    fetch(`/api/revoke-api-key`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + apiKey // Si nécessaire
        },
        body: JSON.stringify({ apiKey }) // ou les données nécessaires
    })
    .then(response => response.json())
    .then(data => {
        // Gérer la réponse ici
        console.log(data);
    })
    .catch(error => {
        console.error('Erreur lors de la révocation de la clé API:', error);
    });
}


// Ensure the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Other initialization code...
});



// Fonction pour copier la clé API
// Fonction pour copier l'API Key
function copyApiKey() {
    const apiKeyInput = document.getElementById('apiKeyInput');
    
    if (navigator.clipboard && window.isSecureContext) {
        // Utiliser l'API Clipboard si disponible (plus moderne et sécurisée)
        navigator.clipboard.writeText(apiKeyInput.value)
            .then(() => showToast('API Key copiée avec succès', document.getElementById('copyButton')))
            .catch(err => console.error('Erreur lors de la copie : ', err));
    } else {
        // Fallback pour les navigateurs plus anciens
        apiKeyInput.select();
        try {
            const success = document.execCommand('copy');
            if (success) {
                showToast('API Key copiée avec succès', document.getElementById('copyButton'));
            } else {
                showToast('Échec de la copie', document.getElementById('copyButton'));
            }
        } catch (err) {
            console.error('Erreur lors de la copie : ', err);
            showToast('Échec de la copie', document.getElementById('copyButton'));
        }
    }
}

// Fonction pour afficher le toast
function showToast(message, element = null) {
    const toast = document.getElementById('toast');
    toast.textContent = message; // Utilisation de textContent au lieu de innerText pour des raisons de performances
    toast.classList.remove('hidden');
    toast.classList.add('show');

    if (element) {
        const rect = element.getBoundingClientRect();
        Object.assign(toast.style, {
            position: 'absolute',
            left: `${rect.left + window.scrollX}px`,
            top: `${rect.bottom + window.scrollY + 10}px`
        });
    } else {
        Object.assign(toast.style, {
            position: 'fixed',
            bottom: '20px',
            right: '20px'
        });
    }

    setTimeout(() => {
        toast.classList.replace('show', 'hidden');
    }, 3000);
}


function createToastContainer() {
    const toastContainer = document.createElement('div');
    toastContainer.id = 'toastContainer';
    toastContainer.className = 'toast-container';
    document.body.appendChild(toastContainer);
    return toastContainer;
}

function toggleApiKeyVisibility() {
    const apiKeyInput = document.getElementById('apiKeyInput');
    const eyeIcon = document.getElementById('eyeIcon');

    if (apiKeyInput.type === 'password') {
        apiKeyInput.type = 'text';
        eyeIcon.classList.remove('fa-eye'); // Change l'icône
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        apiKeyInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash'); // Change l'icône
        eyeIcon.classList.add('fa-eye');
    }
}
