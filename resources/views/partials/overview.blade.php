<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Historique des Logs d'API</h2>

    @if ($apiLogs->isEmpty())
        <p class="text-gray-700">Aucun historique disponible.</p>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de Requête</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Response</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($apiLogs as $log)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $log->created_at }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $log->status }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $log->request_type ?? 'N/A' }}</td> <!-- Nouvelle colonne pour le type de requête -->
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $log->request }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $log->response }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4">
                {{ $apiLogs->links() }} <!-- Pagination links -->
            </div>
        </div>
    @endif
</div>
