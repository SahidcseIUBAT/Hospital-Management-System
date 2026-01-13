@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <div class="bg-white shadow-lg rounded-xl p-6 border border-teal-100">

        <h2 class="text-xl font-semibold text-teal-700 mb-4">
            Appointment Payment
        </h2>

        <div class="space-y-2 text-sm text-gray-700">
            <p><strong>Doctor:</strong> {{ $doctor->name }}</p>
            <p><strong>Specialty:</strong> {{ $doctor->specialty }}</p>
            <p><strong>Appointment Date:</strong> {{ $appointment->date }}</p>
        </div>

        <div class="mt-5 p-4 bg-teal-50 rounded-lg">
            <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-700">Consultation Fee</span>
                <span class="text-lg font-bold text-teal-700">
                    ৳{{ number_format($doctor->fee) }}
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('payment.success') }}" class="mt-6">
            @csrf
            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

            <button
                class="w-full py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition">
                Pay Now (Sandbox)
            </button>
        </form>

        <p class="text-xs text-gray-500 mt-4 text-center">
            This is a sandbox payment. No real money will be charged.
        </p>
    </div>
</div>
@endsection
