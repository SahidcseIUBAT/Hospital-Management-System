@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white rounded-xl shadow-lg p-8">
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

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('patient.book.store', $doctor) }}" class="space-y-6">
            @csrf
            
            {{-- Reason for visit --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">
                    Reason for visit (optional)
                </label>
                <textarea name="reason" rows="4" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('reason') border-red-500 @enderror"
                    placeholder="Describe your symptoms or reason for consultation...">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Date & Time --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium text-gray-700 mb-2">
                        Select Date <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                        name="scheduled_at" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('scheduled_at') border-red-500 @enderror"
                        value="{{ old('scheduled_at') }}" required min="{{ now()->format('Y-m-d\TH:i') }}">
                    @error('scheduled_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Doctor Schedule Info --}}
            @if($doctor->schedules->count() > 0)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-medium text-blue-900 mb-2">Doctor's Availability:</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                        @foreach($doctor->schedules as $schedule)
                            <div class="bg-white border rounded px-2 py-1">
                                {{ ucfirst($schedule->day) }}<br>
                                <span class="font-medium">{{ $schedule->start_time }} - {{ $schedule->end_time }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-yellow-800">No schedule available. Please contact reception.</p>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex gap-4 pt-6">
                <a href="{{ route('patient.doctors') }}" 
                   class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
                    ← Back to Doctors
                </a>
                <button type="submit" 
                        class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200 shadow-lg hover:shadow-xl">
                    Proceed to Payment → 
                    <span class="ml-2 bg-white text-teal-700 px-3 py-1 rounded-full text-xs font-bold">
                        ৳{{ number_format($doctor->fee) }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
