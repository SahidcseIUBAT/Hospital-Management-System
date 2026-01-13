@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-teal-700">My Appointments</h1>
        <a href="{{ route('patient.doctors') }}" 
           class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
            Book New Appointment
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($appointments->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($appointments as $appointment)
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-200 border-l-4 
                    @if($appointment->status === 'pending_payment') border-yellow-500
                    @elseif($appointment->status === 'booked') border-teal-500
                    @elseif($appointment->status === 'completed') border-green-500
                    @else border-gray-500 @endif">
                    
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $appointment->doctor->name }}</h3>
                            <p class="text-teal-600 font-medium">{{ $appointment->doctor->specialty }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-opacity-10 
                            @if($appointment->status === 'pending_payment') bg-yellow-500 text-yellow-800
                            @elseif($appointment->status === 'booked') bg-teal-500 text-teal-800
                            @elseif($appointment->status === 'checked_in') bg-blue-500 text-blue-800
                            @elseif($appointment->status === 'in_progress') bg-orange-500 text-orange-800
                            @elseif($appointment->status === 'completed') bg-green-500 text-green-800
                            @else bg-gray-500 text-gray-800 @endif">
                            {{ ucwords(str_replace('_', ' ', $appointment->status)) }}
                        </span>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <p><strong>Date:</strong> {{ $appointment->scheduled_at->format('M d, Y') }}</p>
                        <p><strong>Time:</strong> {{ $appointment->scheduled_at->format('g:i A') }}</p>
                        <p><strong>Token:</strong> 
                            <span class="font-mono bg-gray-100 px-2 py-1 rounded text-xs">
                                {{ $appointment->token }}
                            </span>
                        </p>
                        @if($appointment->reason)
                            <p><strong>Reason:</strong> {{ Str::limit($appointment->reason, 80) }}</p>
                        @endif
                    </div>
                    
                    <div class="flex gap-2 pt-4 border-t">
                        @if($appointment->status === 'pending_payment')
                            <a href="{{ route('payment.pay', $appointment) }}" 
                               class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-semibold py-2 px-4 rounded-lg text-center transition duration-200">
                                Pay Now
                            </a>
                        @endif
                        <a href="#" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold py-2 px-4 rounded-lg text-center transition duration-200">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-12">
            {{ $appointments->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-gray-50 rounded-xl">
            <div class="w-24 h-24 bg-teal-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                <svg class="w-12 h-12 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">No appointments yet</h3>
            <p class="text-gray-500 mb-8">Start by booking your first appointment with our specialist doctors.</p>
            <a href="{{ route('patient.doctors') }}" 
               class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                Book Appointment Now
            </a>
        </div>
    @endif
</div>
@endsection
