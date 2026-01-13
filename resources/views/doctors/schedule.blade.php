@extends('layouts.app')

@section('content')

<div class="py-8 px-4 max-w-4xl mx-auto sm:px-6 lg:px-8">
    {{-- Header --}}
    
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Clinic Schedule</h1>
                <p class="text-gray-600">Set your weekly availability for patient bookings</p>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
    </div>

    {{-- Add Schedule Form --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Availability
        </h3>
        
        <form method="POST" action="{{ route('doctor.schedule.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Day <span class="text-red-500">*</span></label>
                <select name="day" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all" required>
                    <option value="">Select Day</option>
                    @foreach(['sunday','monday','tuesday','wednesday','thursday','friday','saturday'] as $d)
                        <option value="{{ $d }}" {{ old('day') == $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
                    @endforeach
                </select>
                @error('day') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Start Time <span class="text-red-500">*</span></label>
                <input type="time" 
                       name="start_time" 
                       value="{{ old('start_time') }}" 
                       min="09:00" max="18:00"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all" 
                       required>
                @error('start_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">End Time <span class="text-red-500">*</span></label>
                <input type="time" 
                       name="end_time" 
                       value="{{ old('end_time') }}" 
                       min="10:00" max="22:00"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all" 
                       required>
                @error('end_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit" 
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Slot
                </button>
            </div>
        </form>
    </div>

    {{-- Current Schedule --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-emerald-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Weekly Schedule ({{ $schedules->count() }} slots)
            </h3>
        </div>

        @if($schedules->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Day</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">Time Slot</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($schedules as $s)
                            @php
                                $start = \Carbon\Carbon::parse($s->start_time);
                                $end = \Carbon\Carbon::parse($s->end_time);
                                $duration = $start->diffInMinutes($end);
                                $durationHours = floor($duration / 60);
                                $durationMins = $duration % 60;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex px-3 py-1 bg-emerald-100 text-emerald-800 text-sm font-semibold rounded-full">
                                            {{ ucfirst($s->day) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="font-semibold text-gray-900">
                                        {{ $s->start_time }} - {{ $s->end_time }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">
                                        {{ $durationHours }}h {{ $durationMins }}m
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" action="{{ route('doctor.schedule.delete', $s) }}" class="inline" onsubmit="return confirm('Delete {{ ucfirst($s->day) }} {{ $s->start_time }} - {{ $s->end_time }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm px-3 py-1 rounded hover:bg-red-50 transition-all">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No schedule set</h3>
                <p class="text-gray-600 mb-6">Add your availability so patients can book appointments</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 max-w-2xl mx-auto">
                    <div class="bg-emerald-50 p-4 rounded-xl text-center">
                        <div class="text-2xl font-bold text-emerald-600 mb-1">09:00</div>
                        <div class="text-sm text-gray-600">Morning Slot</div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-xl text-center">
                        <div class="text-2xl font-bold text-blue-600 mb-1">14:00</div>
                        <div class="text-sm text-gray-600">Afternoon</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-xl text-center">
                        <div class="text-2xl font-bold text-purple-600 mb-1">18:00</div>
                        <div class="text-sm text-gray-600">Evening</div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="mt-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl">
            <div class="font-semibold mb-2">Please fix the following:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

@endsection
