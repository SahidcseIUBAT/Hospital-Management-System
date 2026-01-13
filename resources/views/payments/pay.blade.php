@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-teal-700 mb-4">Confirm Payment</h1>
            <div class="w-24 h-24 bg-teal-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                <svg class="w-12 h-12 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Appointment Details --}}
            <div class="bg-gray-50 p-6 rounded-xl">
                <h2 class="text-xl font-semibold text-teal-700 mb-4">Appointment Details</h2>
                <div class="space-y-3 text-sm">
                    <p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
                    <p><strong>Specialty:</strong> {{ $appointment->doctor->specialty }}</p>
                    <p><strong>Date & Time:</strong> {{ $appointment->scheduled_at->format('M d, Y \a\t g:i A') }}</p>
                    <p><strong>Token:</strong> <span class="font-mono bg-teal-100 px-2 py-1 rounded">{{ $appointment->token }}</p>
                </div>
            </div>

            {{-- Payment Summary --}}
            <div class="bg-teal-50 p-6 rounded-xl border-2 border-teal-200">
                <h3 class="text-lg font-semibold text-teal-800 mb-4">Payment Summary</h3>
                <div class="flex justify-between items-center text-lg">
                    <span class="font-semibold">Consultation Fee</span>
                    <span class="text-2xl font-bold text-teal-700">
                        ৳{{ number_format($appointment->doctor->fee ?: 500) }}
                    </span>
                </div>
            </div>

            {{-- Payment Status Check --}}
            @if($appointment->status === 'pending_payment' && $appointment->payment_status !== 'paid')
                {{-- Show Payment Form --}}
                <div class="text-center space-y-4">
                    <form method="POST" action="{{ route('payment.process', $appointment) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="w-full max-w-md bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-lg">
                            <span class="mr-2">💳</span>
                            Pay Now Securely
                            <span class="ml-2 bg-white text-teal-700 px-4 py-1 rounded-full text-sm font-bold inline-block">
                                ৳{{ number_format($appointment->doctor->fee ?: 500) }}
                            </span>
                        </button>
                    </form>
                    
                    <a href="{{ route('patient.doctors') }}" 
                       class="block w-full max-w-md bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
                        ← Back to Doctors List
                    </a>
                </div>
            @else
                {{-- Show Confirmation for Already Paid --}}
                <div class="text-center py-12 bg-green-50 border-2 border-green-200 rounded-xl">
                    <div class="w-20 h-20 bg-green-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-green-800 mb-4">Payment Confirmed!</h3>
                    <p class="text-lg text-green-700 mb-8">
                        This appointment has already been processed successfully.
                        @if($appointment->status === 'booked')
                            Status: <span class="font-semibold text-green-800">Booked</span>
                        @elseif($appointment->payment_status === 'paid')
                            Status: <span class="font-semibold text-green-800">Paid</span>
                        @endif
                    </p>
                    <a href="{{ route('patient.appointments') }}" 
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        View My Appointments
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
