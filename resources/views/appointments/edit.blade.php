@extends('layouts.app')

@section('content')
        <h2 class="font-semibold text-xl">Edit Appointment</h2>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->has('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ $errors->first('error') }}</div>
            @endif

            <div class="bg-gray-300  p-6 shadow rounded">
                <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Patient</label>
                        <select name="patient_id" class="w-full border p-2 rounded">
                            <option value="">-- select patient --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ (old('patient_id') ?? $appointment->patient_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->patient_id ?? '' }} - {{ $p->user->name ?? 'Patient' }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Doctor</label>
                        <select name="doctor_id" class="w-full border p-2 rounded">
                            <option value="">-- select doctor --</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" {{ (old('doctor_id') ?? $appointment->doctor_id) == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Scheduled At</label>
                        <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', $appointment->scheduled_at?->format('Y-m-d\TH:i')) }}" class="w-full border p-2 rounded">
                        @error('scheduled_at') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Status</label>
                        <select name="status" class="w-full border p-2 rounded">
                            @foreach(['booked','checked_in','in_progress','completed','cancelled'] as $s)
                                <option value="{{ $s }}" {{ (old('status', $appointment->status) == $s) ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Reason</label>
                        <textarea name="reason" rows="3" class="w-full border p-2 rounded">{{ old('reason', $appointment->reason) }}</textarea>
                        @error('reason') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                        <a href="{{ route('appointments.index') }}" class="px-4 py-2 border rounded">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection