@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="font-semibold text-xl">
            Prescription — {{ $prescription->consultation->appointment->token }}
        </h2>

        <a href="{{ route('prescriptions.print', $prescription) }}"
           target="_blank"
           class="px-4 py-2 border rounded text-indigo-600">
            Download PDF
        </a>
    </div>

    <div class="bg-white shadow rounded p-6 space-y-4">

        <div class="grid grid-cols-2 gap-4">
            <p><strong>Doctor:</strong> {{ $prescription->consultation->doctor->name }}</p>
            <p><strong>Date:</strong> {{ $prescription->created_at->format('d M Y') }}</p>
        </div>

        <div>
            <strong>Diagnosis</strong>
            <p class="border p-2 rounded mt-1">
                {{ $prescription->consultation->diagnosis ?? 'N/A' }}
            </p>
        </div>

        <div>
            <strong>Medicines</strong>
            <table class="w-full mt-2 border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Medicine</th>
                        <th class="border p-2">Dosage</th>
                        <th class="border p-2">Days</th>
                        <th class="border p-2">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescription->items as $item)
                    <tr>
                        <td class="border p-2">{{ $item->medicine_name }}</td>
                        <td class="border p-2">{{ $item->dosage }}</td>
                        <td class="border p-2">{{ $item->days }}</td>
                        <td class="border p-2">{{ $item->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <strong>Doctor Advice</strong>
            <p class="border p-2 rounded mt-1">
                {{ $prescription->advice ?? 'N/A' }}
            </p>
        </div>

        <div>
            <a href="{{ route('dashboard') }}" class="px-3 py-2 border rounded">
                Back to Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
