@extends('layouts.app')

@section('content')

        <h2 class="font-semibold text-xl">Start Consultation — {{ $appointment->token }}</h2>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <div class="mb-4">
                <strong>Patient:</strong> {{ $appointment->patient->user->name ?? 'N/A' }}<br>
                <strong>Doctor:</strong> {{ $appointment->doctor->name ?? 'Doctor' }}<br>
                <strong>Scheduled:</strong> {{ $appointment->scheduled_at?->format('Y-m-d H:i') }}
            </div>

            @if($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('consultations.store', $appointment) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm">Chief Complaint</label>
                    <input type="text" name="chief_complaint" value="{{ old('chief_complaint') }}" class="w-full border p-2 rounded">
                </div>

                <div class="mb-4 grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-sm">BP</label>
                        <input type="text" name="vitals[bp]" value="{{ old('vitals.bp') }}" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm">Pulse</label>
                        <input type="number" name="vitals[pulse]" value="{{ old('vitals.pulse') }}" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm">Temp (°F)</label>
                        <input type="number" step="0.1" name="vitals[temp]" value="{{ old('vitals.temp') }}" class="w-full border p-2 rounded">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm">Diagnosis</label>
                    <textarea name="diagnosis" rows="4" class="w-full border p-2 rounded">{{ old('diagnosis') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm">Notes</label>
                    <textarea name="notes" rows="3" class="w-full border p-2 rounded">{{ old('notes') }}</textarea>
                </div>

                <hr class="my-4">

                <h3 class="font-semibold mb-2">Prescription</h3>
                <div id="prescription-items" class="space-y-2">
                    <!-- one row template -->
                    <div class="grid grid-cols-4 gap-2 pres-item">
                        <input type="text" name="medicine_name[]" placeholder="Medicine name" class="border p-2 rounded">
                        <input type="text" name="dosage[]" placeholder="Dosage (e.g., 1 tab twice daily)" class="border p-2 rounded">
                        <input type="number" name="days[]" placeholder="Days" class="border p-2 rounded">
                        <input type="text" name="item_notes[]" placeholder="Notes" class="border p-2 rounded">
                    </div>
                </div>

                <div class="mt-2 flex gap-2">
                    <button type="button" id="add-item" class="px-3 py-1 border rounded">Add medicine</button>
                    <button type="button" id="remove-item" class="px-3 py-1 border rounded">Remove last</button>
                </div>

                <div class="mt-4">
                    <label class="block text-sm">Advice</label>
                    <textarea name="advice" rows="2" class="w-full border p-2 rounded">{{ old('advice') }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-sm">Follow-up date (optional)</label>
                    <input type="date" name="follow_up_at" value="{{ old('follow_up_at') }}" class="border p-2 rounded">
                </div>

                <div class="mt-6 flex gap-2">
                    <button class="px-4 py-2 bg-indigo-700 text-green-600 rounded">Save Consultation</button>
                    <a href="{{ route('appointments.show', $appointment) }}" class="px-4 py-2 border rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        const container = document.getElementById('prescription-items');
        document.getElementById('add-item').addEventListener('click', function(){
            const node = document.querySelector('.pres-item').cloneNode(true);
            // clear inputs
            node.querySelectorAll('input').forEach(i => i.value = '');
            container.appendChild(node);
        });
        document.getElementById('remove-item').addEventListener('click', function(){
            const items = container.querySelectorAll('.pres-item');
            if(items.length > 1) items[items.length-1].remove();
        });
    });
    </script>
@endsection