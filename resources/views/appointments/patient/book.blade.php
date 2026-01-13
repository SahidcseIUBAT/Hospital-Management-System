@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">

    <h2 class="text-2xl font-semibold text-teal-700 mb-6">
        Book Appointment with {{ $doctor->name }}
    </h2>

    <div class="bg-white rounded-xl shadow p-6 space-y-4">

        {{-- Doctor info --}}
        <div>
            <p class="text-gray-600">
                <span class="font-medium">Specialty:</span>
                {{ $doctor->specialty }}
            </p>

            <p class="text-teal-700 font-semibold mt-1">
                Consultation Fee: ৳{{ number_format($doctor->fee) }}
            </p>
        </div>

        {{-- Availability --}}
        <div>
            <p class="text-sm font-medium text-gray-600 mb-1">
                Available Days
            </p>

            @foreach($doctor->schedules as $s)
                <span class="inline-block bg-teal-50 text-teal-700 text-xs px-2 py-1 rounded mr-1 mb-1">
                    {{ ucfirst($s->day) }}
                </span>
            @endforeach
        </div>

        <hr>

        {{-- Booking form --}}
        <form method="POST" action="{{ route('patient.book.store', $doctor) }}">
            @csrf

            {{-- Date --}}
            <div>
                <label class="block font-medium mb-1">
                    Select Appointment Date
                </label>

                <input type="date"
                       name="date"
                       min="{{ now()->toDateString() }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            {{-- Reason --}}
            <div>
                <label class="block font-medium mb-1">
                    Reason (optional)
                </label>

                <textarea name="reason"
                          rows="3"
                          class="w-full border rounded px-3 py-2"
                          placeholder="Short description..."></textarea>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-teal-600 text-white py-3 rounded-lg font-semibold hover:bg-teal-700 transition">
                Proceed to Payment
            </button>
        </form>
    </div>

    <div class="mt-4">
        <a href="{{ route('patient.book') }}"
           class="text-teal-600 hover:underline">
            ← Back to Doctors
        </a>
    </div>
</div>
@endsection
