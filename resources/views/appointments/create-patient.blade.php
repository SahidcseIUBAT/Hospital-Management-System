@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <h2 class="text-xl font-semibold mb-4">Book Appointment</h2>

    <div class="bg-white p-6 shadow rounded">

        <!-- Date filter -->
        <form method="GET" action="{{ route('appointments.create') }}" class="mb-6">
            <label class="block font-medium mb-1">Select Date</label>
            <div class="flex gap-2">
                <input type="date"
                       name="date"
                       value="{{ $date }}"
                       class="border p-2 rounded"
                       required>

                <button class="px-4 py-2 bg-gray-200 rounded">
                    Check Availability
                </button>
            </div>
        </form>

        <hr class="mb-6">

        @if($doctors->count() === 0)
            <div class="text-red-600 font-medium">
                No doctors available on this date.
            </div>
        @else
            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf

                <input type="hidden" name="date" value="{{ $date }}">

                <!-- Doctor -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Available Doctors</label>
                    <select name="doctor_id" class="w-full border p-2 rounded" required>
                        <option value="">-- Select Doctor --</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}">
                                {{ $d->name }} — {{ ucfirst($d->specialty) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Reason -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Reason (optional)</label>
                    <textarea name="reason"
                              rows="3"
                              class="w-full border p-2 rounded"></textarea>
                </div>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Book Appointment
                </button>
            </form>
        @endif
    </div>
</div>
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul class="list-disc pl-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
