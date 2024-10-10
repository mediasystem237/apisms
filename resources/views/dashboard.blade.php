@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 dark:text-white">Tableau de bord API SMS</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="dashboard-stats">
        <!-- Carte pour les statistiques d'envoi -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 dark:text-white">Statistiques d'envoi</h2>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400" id="totalSentSMS">{{ $totalSentSMS ?? 0 }}</p>
            <p class="text-gray-600 dark:text-gray-300">SMS envoyés aujourd'hui</p>
        </div>
        
        <!-- Carte pour le crédit restant -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 dark:text-white">Crédit SMS</h2>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400" id="remainingCredit">{{ $remainingCredit ?? 0 }}</p>
            <p class="text-gray-600 dark:text-gray-300">SMS restants</p>
        </div>
        
        <!-- Carte pour les erreurs d'envoi -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 dark:text-white">Erreurs d'envoi</h2>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400" id="failedSMS">{{ $failedSMS ?? 0 }}</p>
            <p class="text-gray-600 dark:text-gray-300">Échecs aujourd'hui</p>
        </div>
    </div>

    <script>
            function updateDashboardStats() {
            console.log("Fetching dashboard stats..."); // Add this line
            fetch('{{ route('dashboard.stats') }}')
                .then(response => {
                    console.log("Response received:", response); // Add this line
                    return response.json();
                })
                .then(data => {
                    console.log("Data received:", data); // Add this line
                    document.getElementById('totalSentSMS').innerText = data.totalSentSMS;
                    document.getElementById('remainingCredit').innerText = data.remainingCredit;
                    document.getElementById('failedSMS').innerText = data.failedSMS;
                })
                .catch(error => {
                    console.error('Error fetching dashboard stats:', error);
                });
        }


        document.addEventListener('DOMContentLoaded', function() {
            // Appel initial pour récupérer les stats
            updateDashboardStats();

            // Mise à jour automatique toutes les 30 secondes
            setInterval(updateDashboardStats, 30000); // 30000 millisecondes = 30 secondes
        });
    </script>
</div>
@endsection
