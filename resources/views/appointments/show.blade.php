@extends('layouts.app')

@section('content')
        <h2 class="font-semibold text-xl">Appointment: {{ $appointment->token }}</h2>


    @role('doctor')
    <a href="{{ route('consultations.create', $appointment->id) }}"
       class="px-3 py-2 bg-green-600 text-black rounded inline-block mb-4">
        Start Consultation
    </a>
@endrole

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded">
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Token</dt>
                        <dd class="font-medium">{{ $appointment->token }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm text-gray-500">Patient</dt>
                        <dd class="font-medium">{{ $appointment->patient->user->name ?? 'N/A' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm text-gray-500">Doctor</dt>
                        <dd class="font-medium">{{ $appointment->doctor->name ?? ($appointment->doctor->user->name ?? 'Doctor') }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm text-gray-500">Scheduled At</dt>
                        <dd class="font-medium">{{ $appointment->scheduled_at ? \Carbon\Carbon::parse($appointment->scheduled_at)->format('Y-m-d H:i') : '-' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm text-gray-500">Status</dt>
                        <dd class="font-medium">{{ ucfirst($appointment->status) }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm text-gray-500">Reason</dt>
                        <dd class="font-medium">{{ $appointment->reason ?? '-' }}</dd>
                    </div>
                </dl>

                {{-- Prescription section (Doctor + Patient only) --}}
@if($appointment->consultation && $appointment->consultation->prescription)
    <div class="mt-4 p-4 border rounded bg-gray-200">
        <h4 class="font-semibold text-lg mb-6">Prescription</h4>

        <a href="{{ route('prescriptions.show', $appointment->consultation->prescription) }}"
           class="px-3 py-2 text-black border rounded">
            View Prescription
        </a>
    </div>
@endif


                <div class="mt-4 flex gap-2">
                    <a href="{{ route('appointments.edit', $appointment) }}" class="px-3 py-2 bg-yellow-600 border text-black rounded">Edit</a>
                    <a href="{{ route('appointments.index') }}" class="px-3 py-2 border rounded">Back</a>
                </div>
            </div>

        </div>
    </div>
@endsection

