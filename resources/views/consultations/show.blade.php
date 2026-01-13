@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-semibold text-xl">
            Consultation —
            <span class="text-indigo-600">{{ $consultation->appointment->token }}</span>
        </h2>

        @role('doctor')
            @if(!$consultation->completed_at)
                <form method="POST"
                      action="{{ route('consultations.complete', $consultation) }}"
                      onsubmit="return confirm('Complete this consultation?')">
                    @csrf
                    <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-green-600 rounded shadow">
                        Complete Consultation
                    </button>
                </form>
            @endif
        @endrole
    </div>
    

    <div class="bg-white shadow rounded-lg p-2 space-y-4">

        <!-- Patient / Doctor Meta -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm text-gray-700">
            <div><strong>Patient:</strong> {{ $consultation->patient->user->name }}</div>
            <div><strong>Doctor:</strong> {{ $consultation->doctor->name }}</div>
            <div><strong>Started:</strong> {{ $consultation->started_at?->format('Y-m-d H:i') }}</div>
            <div><strong>Completed:</strong> {{ $consultation->completed_at?->format('Y-m-d H:i') ?? '-' }}</div>
        </div>

        <!-- Compact Clinical Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-gray-50 border rounded p-2">
                <h4 class="font-semibold text-sm mb-1">Diagnosis</h4>
                <div class="text-sm text-gray-700">
                    {{ $consultation->diagnosis ?? '-' }}
                </div>
            </div>

            <div class="bg-gray-50 border rounded p-2">
                <h4 class="font-semibold text-sm mb-1">Notes</h4>
                <div class="text-sm text-gray-700">
                    {{ $consultation->notes ?? '-' }}
                </div>
            </div>

            <div class="bg-gray-50 border rounded p-2">
                <h4 class="font-semibold text-sm mb-1">Vitals</h4>
                <div class="text-sm text-gray-700 space-x-3">
                    <span><strong>BP:</strong> {{ $consultation->vitals['bp'] ?? '-' }}</span>
                    <span><strong>Pulse:</strong> {{ $consultation->vitals['pulse'] ?? '-' }}</span>
                    <span><strong>Temp:</strong> {{ $consultation->vitals['temp'] ?? '-' }}</span>
                </div>
            </div>

        </div>

        <!-- Prescription (MAIN FOCUS) -->
        <div class="border-t pt-4">
            <h3 class="font-semibold text-lg mb-3 text-indigo-700">
                Prescription
            </h3>

            @if($consultation->prescription)

                <div class="mb-2 text-sm">
                    <strong>Advice:</strong>
                    <span class="text-gray-700">{{ $consultation->prescription->advice ?? '-' }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300 text-sm">
                        <thead class="bg-indigo-50">
                            <tr>
                                <th class="px-3 py-2 border text-left">Medicine</th>
                                <th class="px-3 py-2 border text-left">Dosage</th>
                                <th class="px-3 py-2 border text-center">Days</th>
                                <th class="px-3 py-2 border text-left">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultation->prescription->items as $it)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 border font-medium">{{ $it->medicine_name }}</td>
                                    <td class="px-3 py-2 border">{{ $it->dosage }}</td>
                                    <td class="px-3 py-2 border text-center">{{ $it->days }}</td>
                                    <td class="px-3 py-2 border">{{ $it->notes }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <div class="text-gray-500 italic text-sm">
                    No prescription added.
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="flex justify-end pt-3">
            <a href="{{ route('appointments.show', $consultation->appointment) }}"
               class="px-4 py-2 border rounded hover:bg-gray-50">
                Back to Appointment
            </a>
        </div>
        
        @if($consultation->prescription)
    <a href="{{ route('prescriptions.print', $consultation->prescription) }}"
       target="_blank"
       class="px-3 py-2 border rounded text-indigo-600">
        Print / PDF
    </a>
@endif


    </div>
</div>
@endsection
