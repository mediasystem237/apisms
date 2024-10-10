@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <h2 class="text-5xl font-extrabold mb-8 text-blue-800 text-center animate-fade-in-down">
        Vérification du Solde SMS
    </h2>

    @if ($errors->any())
        <div class="bg-red-50 text-red-800 p-4 rounded-lg mb-8 shadow-lg animate-fade-in">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">Erreur:</span>
            </div>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (isset($smsBalance))
        <div class="bg-white p-8 rounded-2xl shadow-xl mb-12 transform hover:scale-105 transition-all duration-300 ease-in-out">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <svg class="w-12 h-12 text-blue-600 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-3xl font-bold text-gray-800">Votre solde SMS</h3>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Dernière mise à jour</p>
                    <p class="text-md font-medium text-gray-700">{{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-4 rounded-xl">
                    <p class="text-lg text-gray-600 mb-1">Crédits</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $smsBalance }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-xl">
                    <p class="text-lg text-gray-600 mb-1">Expiration du compte</p>
                    <p class="text-xl font-semibold text-green-600">{{ $accountExpDate ?? 'Non disponible' }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-xl">
                    <p class="text-lg text-gray-600 mb-1">Expiration du solde</p>
                    <p class="text-xl font-semibold text-purple-600">{{ $balanceExpDate ?? 'Non disponible' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-xl">
            <h3 class="text-3xl font-bold text-gray-800 mb-8">Détails du solde par Pays</h3>
            @if(isset($balanceDetails) && count($balanceDetails) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($balanceDetails as $balance)
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-xl font-bold text-gray-700">{{ $balance['country_name'] }}</h4>
                                <span class="text-sm font-medium bg-blue-100 text-blue-800 py-1 px-2 rounded">{{ $balance['country_code'] }}</span>
                            </div>
                            <div class="space-y-2">
                                <p class="text-gray-600">Crédits : <span class="text-blue-600 font-semibold">{{ $balance['credit'] }}</span></p>
                                <p class="text-gray-600">Taux de crédit : <span class="font-medium">{{ $balance['credit_rate'] ?? 'Non disponible' }}</span></p>
                                <p class="text-gray-600">Expiration : <span class="font-medium">{{ $balance['expire_date'] ?? 'Non disponible' }}</span></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xl text-gray-600 text-center">Aucun détail de solde disponible pour le moment.</p>
            @endif
        </div>
    @else
        <div class="text-center mb-12">
            <p class="text-xl text-gray-600 mb-8">Cliquez sur le bouton ci-dessous pour vérifier votre solde SMS.</p>
            <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_qcrcj8xf.json" background="transparent" speed="1" style="width: 300px; height: 300px; margin: 0 auto;" loop autoplay></lottie-player>
        </div>
    @endif

    <form action="{{ route('check.balance') }}" method="POST" class="mt-12 text-center">
        @csrf
        <button type="submit" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white transition-all duration-200 bg-blue-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 hover:bg-blue-700 transform hover:scale-105">
            <span class="absolute inset-0 w-full h-full mt-1 ml-1 transition-all duration-300 ease-in-out bg-blue-800 rounded-xl group-hover:mt-0 group-hover:ml-0"></span>
            <span class="absolute inset-0 w-full h-full bg-blue-600 rounded-xl"></span>
            <span class="relative flex items-center">
                <svg class="w-6 h-6 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Vérifier le solde
            </span>
        </button>
    </form>
</div>

@push('scripts')
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<script>
    // Add any additional JavaScript for animations or interactivity here
</script>
@endpush

<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translate3d(0, -20px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out;
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endsection