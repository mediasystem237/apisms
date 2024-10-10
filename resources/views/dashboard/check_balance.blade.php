<!-- resources/views/dashboard/check_balance.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold">Account Balance</h1>
    @if(session('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif
    @if(isset($balance))
        <p class="mt-4 text-xl">Your Current Balance: <span class="font-semibold">{{ $balance }}</span></p>
    @else
        <p class="mt-4 text-gray-500">Balance information unavailable.</p>
    @endif
</div>
@endsection
