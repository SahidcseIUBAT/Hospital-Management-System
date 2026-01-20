@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 bg-teal-100 rounded-lg flex items-center justify-center">
                <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Appointment Details</h1>
                <p class="text-sm font-mono bg-gray-100 px-3 py-1 rounded text-teal-700">
                    Token: {{ $appointment->token }}
                </p>
            </div>
        </div>

        {{-- Doctor Actions --}}
        
       @role('doctor')
    @if(auth()->user()->doctor &&
        auth()->user()->doctor->id === $appointment->doctor_id &&
        in_array($appointment->status, ['booked', 'checked_in', 'in_progress']))
        
        <div class="mb-6">
            <a href="{{ route('consultations.create', $appointment->id) }}"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Start Consultation
            </a>
        </div>

    @endif
@endrole



    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        {{-- Details Grid --}}
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                {{-- Patient Info --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        Patient Information
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $appointment->patient->user->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">{{ $appointment->patient->patient_id ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Doctor Info --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 bg-teal-500 rounded-full"></span>
                        Doctor Information
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $appointment->doctor->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">{{ $appointment->doctor->specialty ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Schedule & Status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Scheduled Date & Time</h4>
                    <div class="p-4 bg-gradient-to-r from-teal-50 to-blue-50 rounded-lg border-l-4 border-teal-400">
                        <p class="text-xl font-semibold text-gray-900">
                            {{ $appointment->scheduled_at ? \Carbon\Carbon::parse($appointment->scheduled_at)->format('l, F jS, Y \a\t g:i A') : '-' }}
                        </p>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Status</h4>
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border-l-4 
                        @if($appointment->status === 'pending_payment') border-yellow-400
                        @elseif($appointment->status === 'booked') border-teal-400
                        @elseif($appointment->status === 'checked_in') border-blue-400
                        @elseif($appointment->status === 'in_progress') border-orange-400
                        @elseif($appointment->status === 'completed') border-green-400
                        @else border-gray-400 @endif">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-opacity-20
                            @if($appointment->status === 'pending_payment') bg-yellow-500 text-yellow-800
                            @elseif($appointment->status === 'booked') bg-teal-500 text-teal-800
                            @elseif($appointment->status === 'checked_in') bg-blue-500 text-blue-800
                            @elseif($appointment->status === 'in_progress') bg-orange-500 text-orange-800
                            @elseif($appointment->status === 'completed') bg-green-500 text-green-800
                            @else bg-gray-500 text-gray-800 @endif">
                            {{ ucwords(str_replace('_', ' ', $appointment->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Reason --}}
            @if($appointment->reason)
            <div class="mb-8">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Reason for Visit</h4>
                <div class="p-5 bg-indigo-50 border border-indigo-200 rounded-lg">
                    <p class="text-gray-800 leading-relaxed">{{ $appointment->reason }}</p>
                </div>
            </div>
            @endif

            {{-- Prescription --}}
            @if($appointment->consultation && $appointment->consultation->prescription)
            <div class="mb-8">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                    Prescription 
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                </h4>
                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                    <a href="{{ route('prescriptions.show', $appointment->consultation->prescription) }}"
                       class="inline-flex items-center gap-2 bg-white border border-green-300 text-green-800 hover:bg-green-50 px-5 py-2.5 rounded-lg font-medium transition-all hover:shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        View Prescription
                    </a>
                </div>
            </div>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-wrap gap-3 justify-end">
                @role('admin')
                    <a href="{{ route('appointments.edit', $appointment) }}" 
                       class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md">
                        Edit Appointment
                    </a>
                @endrole
                <a href="{{ route('appointments.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 bg-white hover:bg-gray-50 font-medium rounded-lg transition-all shadow-sm hover:shadow-md">
                    Back to Appointments
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
