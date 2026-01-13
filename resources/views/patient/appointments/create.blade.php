@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">

    <div class="bg-white rounded-xl shadow p-6 text-center">

        <h2 class="text-2xl font-semibold text-teal-700 mb-3">
            Book an Appointment
        </h2>

        <p class="text-gray-600 mb-6">
            To ensure proper scheduling and secure payment,
            appointments must be booked through our guided booking process.
        </p>

        <div class="bg-teal-50 border border-teal-100 rounded-lg p-4 text-sm text-teal-700 mb-6">
            ✔ Choose a doctor<br>
            ✔ View availability<br>
            ✔ Confirm fee<br>
            ✔ Complete payment
        </div>

        <a href="{{ route('patient.book') }}"
           class="inline-block px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition">
            Start Booking
        </a>

        <div class="mt-4">
            <a href="{{ route('dashboard') }}"
               class="text-sm text-gray-500 hover:underline">
                ← Back to Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
