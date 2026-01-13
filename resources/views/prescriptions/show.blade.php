@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="font-semibold text-xl">
            Prescription — {{ $prescription->consultation->appointment->token }}
        </h2>

        <a href="{{ route('prescriptions.print', $prescription) }}"
           class="px-3 py-2 border rounded bg-white text-red-600">
            Print / PDF
        </a>
    </div>

    <div class="bg-white shadow rounded p-6">

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <p><strong>Patient:</strong>
                    {{ $prescription->consultation->patient->user->name ?? 'N/A' }}
                </p>
                <p><strong>Doctor:</strong>
                    {{ $prescription->consultation->doctor->name ?? 'Doctor' }}
                </p>
            </div>
            

            <div class="text-right">
                <p><strong>Date:</strong>
                    {{ $prescription->created_at->format('d M Y') }}
                </p>
            </div>
        </div>

        <hr class="my-4">

        <h4 class="font-semibold mb-2">Advice</h4>
        <p class="mb-4">
            {{ $prescription->advice ?? '—' }}
        </p>

        <h4 class="font-semibold mb-2">Medicines</h4>

        <table class="w-full border-collapse border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Medicine</th>
                    <th class="border px-2 py-1">Dosage</th>
                    <th class="border px-2 py-1">Days</th>
                    <th class="border px-2 py-1">Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescription->items as $item)
                    <tr>
                        <td class="border px-2 py-1">{{ $item->medicine_name }}</td>
                        <td class="border px-2 py-1">{{ $item->dosage }}</td>
                        <td class="border px-2 py-1">{{ $item->days }}</td>
                        <td class="border px-2 py-1">{{ $item->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border px-2 py-2 text-center text-gray-500">
                            No medicines prescribed.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="px-3 py-2 border rounded">
                Back to Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
