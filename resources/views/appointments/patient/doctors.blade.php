@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <h2 class="text-2xl font-semibold text-teal-700 mb-6">
        Book an Appointment
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($doctors as $doctor)
            <div class="bg-white border border-teal-100 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $doctor->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $doctor->specialty }}
                    </p>

                    <p class="mt-3 text-teal-700 font-semibold">
                        Fee: ৳{{ number_format($doctor->fee) }}
                    </p>

                    <div class="mt-3 text-sm text-gray-600">
                        <span class="font-medium">Available:</span>
                        @forelse($doctor->schedules as $s)
                            <span class="inline-block bg-teal-50 text-teal-700 px-2 py-1 rounded text-xs mr-1">
                                {{ ucfirst($s->day) }}
                            </span>
                        @empty
                            <span class="text-red-500">No schedule</span>
                        @endforelse
                    </div>

                    <!-- <a href="{{ route('patient.book.doctor', $doctor) }}" -->

                    
                    
                    <a href="{{ route('patient.book.doctor', $doctor->id) }}">
                        <span class="mt-5 inline-block w-full text-center bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition">
                            Book Appointment
                        </span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
