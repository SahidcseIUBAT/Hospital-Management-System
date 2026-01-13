@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-teal-700 mb-4">Find Your Doctor</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Browse our specialist doctors and book appointments online instantly
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($doctors as $doctor)
            <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-teal-200 hover:-translate-y-2 group">
                <div class="p-8 text-center">
                    {{-- Doctor Avatar --}}
                    <div class="w-24 h-24 bg-gradient-to-r from-teal-500 to-blue-500 rounded-full mx-auto mb-6 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    {{-- Doctor Info --}}
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $doctor->name }}</h3>
                    <p class="text-teal-600 font-semibold text-lg mb-1">{{ $doctor->specialty }}</p>
                    
                    <div class="flex items-center justify-center mb-6">
                        <span class="text-2xl font-bold text-teal-700">৳{{ number_format($doctor->fee) }}</span>
                        <span class="text-sm text-gray-500 ml-2">per consultation</span>
                    </div>

                    {{-- Availability --}}
                    @if($doctor->schedules->count() > 0)
                        <div class="bg-teal-50 p-4 rounded-xl mb-6">
                            <p class="text-sm font-medium text-teal-800 mb-2">Available Days:</p>
                            <div class="flex flex-wrap gap-1 justify-center">
                                @foreach($doctor->schedules->take(3) as $schedule)
                                    <span class="px-2 py-1 bg-teal-200 text-teal-800 text-xs rounded-full">
                                        {{ ucfirst($schedule->day) }}
                                    </span>
                                @endforeach
                                @if($doctor->schedules->count() > 3)
                                    <span class="px-2 py-1 bg-gray-200 text-gray-600 text-xs rounded-full">+{{ $doctor->schedules->count() - 3 }}</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Book Button --}}
                    <a href="{{ route('patient.book.doctor', $doctor->id) }}" 
                       class="w-full block bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 text-lg flex items-center justify-center gap-3 group-hover:scale-[1.02]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Book Appointment
                    </a>

                    {{-- Phone --}}
                    <p class="mt-4 text-sm text-gray-500">{{ $doctor->phone }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-600 mb-2">No Doctors Available</h3>
                <p class="text-gray-500 mb-8">Please check back later or contact reception.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
