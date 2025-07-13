@extends('components.dashboard-layout')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Reservation Details</h1>
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-yellow-700 mb-2">Plot: {{ $reservation->plot->title ?? 'N/A' }}</h2>
        <p class="mb-2"><strong>Status:</strong> <span class="font-semibold">{{ ucfirst($reservation->status) }}</span></p>
        <p class="mb-2"><strong>Reserved At:</strong> {{ $reservation->created_at->format('M d, Y H:i') }}</p>
        <p class="mb-2"><strong>Expires At:</strong> {{ $reservation->expires_at ? $reservation->expires_at->format('M d, Y H:i') : 'N/A' }}</p>
        <p class="mb-2"><strong>Amount:</strong> MWK {{ number_format($reservation->plot->price ?? 0, 2) }}</p>
        <p class="mb-2"><strong>Payment Status:</strong> {{ optional($reservation->payment)->status ?? 'N/A' }}</p>
        <a href="{{ route('customer.reservations.index') }}" class="inline-block mt-4 px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Back to My Reservations</a>
    </div>
</div>
@endsection 