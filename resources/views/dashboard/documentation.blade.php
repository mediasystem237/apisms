@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Main content -->
    <div class="ml-64 w-full">
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <h1 id="main-title" class="text-3xl font-bold mb-6">Documentation des Endpoints API</h1>
                    <p class="text-gray-600 mb-6">Base URL: <code class="bg-gray-100 px-2 py-1 rounded">https://api.sms.mediasystem.cm</code></p>

                    <div class="space-y-8">
                        <div id="send-sms">
                            <h2 class="text-2xl font-semibold mb-4">1. Envoyer un SMS</h2>
                            <div class="bg-blue-50 p-4 rounded-md">
                                <p><strong class="text-blue-700">Method:</strong> POST</p>
                                <p><strong class="text-blue-700">Endpoint:</strong> <code>/api/send-sms</code></p>
                            </div>
                            <h3 class="text-lg font-medium mt-4 mb-2">Paramètres requis :</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><code class="bg-gray-100 px-1 rounded">api_key</code> (string) : Votre clé API</li>
                                <li><code class="bg-gray-100 px-1 rounded">senderid</code> (string) : Nom ou numéro de l'expéditeur</li>
                                <li><code class="bg-gray-100 px-1 rounded">mobiles</code> (string) : Numéros de téléphone du ou des destinataires</li>
                                <li><code class="bg-gray-100 px-1 rounded">sms</code> (string) : Contenu du message</li>
                            </ul>
                        </div>

                        <div id="check-balance">
                            <h2 class="text-2xl font-semibold mb-4">2. Vérifier le solde</h2>
                            <div class="bg-green-50 p-4 rounded-md">
                                <p><strong class="text-green-700">Method:</strong> GET</p>
                                <p><strong class="text-green-700">Endpoint:</strong> <code>/api/check-balance</code></p>
                            </div>
                            <h3 class="text-lg font-medium mt-4 mb-2">Paramètres requis :</h3>
                            <ul class="list-disc pl-6">
                                <li><code class="bg-gray-100 px-1 rounded">api_key</code> (string) : Votre clé API</li>
                            </ul>
                        </div>

                        <div id="sms-history">
                            <h2 class="text-2xl font-semibold mb-4">3. Historique des SMS</h2>
                            <div class="bg-yellow-50 p-4 rounded-md">
                                <p><strong class="text-yellow-700">Method:</strong> GET</p>
                                <p><strong class="text-yellow-700">Endpoint:</strong> <code>/api/sms-history</code></p>
                            </div>
                            <h3 class="text-lg font-medium mt-4 mb-2">Paramètres requis :</h3>
                            <ul class="list-disc pl-6">
                                <li><code class="bg-gray-100 px-1 rounded">api_key</code> (string) : Votre clé API</li>
                            </ul>
                        </div>

                        <div id="dlr-webhook">
                            <h2 class="text-2xl font-semibold mb-4">4. DLR Webhook</h2>
                            <div class="bg-purple-50 p-4 rounded-md">
                                <p><strong class="text-purple-700">Method:</strong> POST</p>
                                <p><strong class="text-purple-700">Endpoint:</strong> <code>/api/dlr-webhook</code></p>
                            </div>
                            <h3 class="text-lg font-medium mt-4 mb-2">Paramètres attendus :</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><code class="bg-gray-100 px-1 rounded">messageid</code> (string) : ID du message</li>
                                <li><code class="bg-gray-100 px-1 rounded">mobileno</code> (string) : Numéro de téléphone</li>
                                <li><code class="bg-gray-100 px-1 rounded">status</code> (string) : Statut de livraison</li>
                                <li><code class="bg-gray-100 px-1 rounded">deliverytime</code> (string) : Heure de livraison</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection