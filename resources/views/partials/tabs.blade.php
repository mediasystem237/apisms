<!-- partials/tabs.blade.php -->
<div class="mb-8">
    <nav class="flex space-x-4 border-b">
        <a href="javascript:void(0);" class="tab-link px-3 py-2 text-sm font-medium text-gray-600 border-b-2" 
           id="tab-overview" onclick="showTab('overview')">Overview</a>
        <a href="javascript:void(0);" class="tab-link px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2"
           id="tab-apiKeys" onclick="showTab('apiKeys')">API Keys</a>
        <!-- Add other tab links here -->
    </nav>
</div>


<script>
// Gérer les onglets actifs
function showTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
    // Remove active styles from all tab links
    document.querySelectorAll('.tab-link').forEach(link => link.classList.remove('border-blue-500', 'text-blue-500'));

    // Show the selected tab content
    const selectedTab = document.getElementById(tabId);
    const selectedLink = document.getElementById('tab-' + tabId);

    if (selectedTab) {
        selectedTab.classList.remove('hidden');
    }
    if (selectedLink) {
        selectedLink.classList.add('border-blue-500', 'text-blue-500');
    }

    // Store the active tab in localStorage
    localStorage.setItem('activeTab', tabId);
}

// Afficher le tab actif au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Check if there is an active tab stored in localStorage
    const activeTab = localStorage.getItem('activeTab') || 'overview'; // Default to 'overview' if none found
    showTab(activeTab); // Display the active tab
});
</script>
