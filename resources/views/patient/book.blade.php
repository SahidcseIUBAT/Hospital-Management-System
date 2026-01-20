@extends('layouts.app')

@section('content')

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white rounded-xl shadow-lg p-8">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-teal-700 mb-2">
                Book Appointment with {{ $doctor->name }}
            </h1>
            <p class="text-gray-600 text-lg">{{ $doctor->specialty }}</p>

            <div class="mt-4 p-4 bg-teal-50 border border-teal-200 rounded-lg">
                <span class="text-2xl font-bold text-teal-700">
                    Fee: ৳{{ number_format($doctor->fee) }}
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('patient.book.store', $doctor) }}" id="bookingForm" class="space-y-6">
            @csrf

            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
            <input type="hidden" name="schedule_id" id="schedule_id">

            {{-- Reason --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">
                    Reason for visit (optional)
                </label>
                <textarea name="reason" rows="4"
                    class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500"
                    placeholder="Describe your symptoms...">{{ old('reason') }}</textarea>
            </div>



            <div>
    <label class="block font-medium text-gray-700 mb-2">
        Select Doctor Schedule <span class="text-red-500">*</span>
    </label>

    <select name="schedule_id"
            id="schedule_select"
            required
            class="w-full border rounded px-3 py-2">
        <option value="">Select a schedule</option>

        @foreach($doctor->schedules as $schedule)
            <option value="{{ $schedule->id }}"
                    data-day="{{ strtolower($schedule->day) }}">
                {{ ucfirst($schedule->day) }}
                ({{ $schedule->start_time }} - {{ $schedule->end_time }})
            </option>
        @endforeach
    </select>

    @error('schedule_id')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>


<div>
    <label class="block font-medium text-gray-700 mb-2">
        Select Date <span class="text-red-500">*</span>
    </label>

    <input type="date"
           name="date"
           id="appointment_date"
           min="{{ now()->toDateString() }}"
           max="{{ now()->addDays(7)->toDateString() }}"
           required
           class="w-full border rounded px-3 py-2">

    @error('date')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>



            {{-- Doctor Schedule Info (Read-only) --}}
            @if($doctor->schedules->count())
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-medium text-blue-900 mb-2">Doctor's Weekly Availability</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        @foreach($doctor->schedules as $schedule)
                            <div class="bg-white border rounded px-2 py-1">
                                {{ ucfirst($schedule->day) }}<br>
                                <span class="font-medium">
                                    {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-4 pt-6">
                <a href="{{ route('patient.doctors') }}"
                   class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg text-center">
                    ← Back
                </a>

                <button type="submit"
                        id="submitBtn"
                        class="flex-1 bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-lg">
                    Proceed to Payment →
                </button>
            </div>

        </form>
    </div>
</div>
@endsection


<script>
const scheduleSelect = document.getElementById('schedule_select');
const dateInput = document.getElementById('appointment_date');
const leaveDates = @json($leaveDates ?? []);

scheduleSelect.addEventListener('change', () => {
    dateInput.value = '';
});

dateInput.addEventListener('change', function () {
    const selectedOption = scheduleSelect.options[scheduleSelect.selectedIndex];

    if (!selectedOption.value) {
        alert('Please select a schedule first.');
        this.value = '';
        return;
    }

    const scheduleDay = selectedOption.dataset.day;
    const date = this.value;

    if (leaveDates.includes(date)) {
        alert('Doctor is on leave on this date.');
        this.value = '';
        return;
    }

    const dayMap = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
    const selectedDay = dayMap[new Date(date + 'T00:00:00').getDay()];

    if (selectedDay !== scheduleDay) {
        alert(`This schedule is only available on ${scheduleDay}.`);
        this.value = '';
    }
});
</script>
