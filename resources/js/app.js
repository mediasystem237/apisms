import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function showToast(message) {
    const toastContainer = document.getElementById('toast-container');

    // Créer un nouvel élément toast
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<p>${message}</p>`;

    // Ajouter le toast au conteneur
    toastContainer.appendChild(toast);

    // Supprimer le toast après 3 secondes
    setTimeout(() => {
        toast.classList.add('fade-out');
        toast.addEventListener('transitionend', () => toast.remove());
    }, 3000);
}

// Exemple d'utilisation
function copyApiKey() {
    const apiKey = document.getElementById("apiKey").innerText;
    navigator.clipboard.writeText(apiKey).then(() => {
        showToast("API Key copied!");
    }).catch(err => {
        showToast("Failed to copy API Key");
    });
}
