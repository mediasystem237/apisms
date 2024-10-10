<!-- sidedoc.blade.php -->
<div class="flex">
    <!-- Main content for the documentation -->
    <!-- Sidebar -->
    <div id="sidebar" class="w-128 h-screen bg-gray-800 text-white p-4 fixed right-0 top-0 overflow-y-auto">
        <h2 class="text-xl font-bold mb-4">Table des matières</h2>
        <ul class="space-y-2">
            <li><a href="#main-title" class="hover:text-gray-300">Documentation des Endpoints API</a></li>
            <li><a href="#send-sms" class="hover:text-gray-300">1. Envoyer un SMS</a></li>
            <li><a href="#check-balance" class="hover:text-gray-300">2. Vérifier le solde</a></li>
            <li><a href="#sms-history" class="hover:text-gray-300">3. Historique des SMS</a></li>
            <li><a href="#dlr-webhook" class="hover:text-gray-300">4. DLR Webhook</a></li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for sidebar links
    document.querySelectorAll('#sidebar a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
</script>
