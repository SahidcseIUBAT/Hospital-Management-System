@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto px-4">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-teal-700">
                Create Appointment (Admin)
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Admin can create appointments directly and accept cash payments.
            </p>
        </div>

        {{-- Global error --}}
        @if($errors->has('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ $errors->first('error') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-xl p-6">
            <form action="{{ route('appointments.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Patient --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Patient <span class="text-red-500">*</span>
                    </label>
                    <select name="patient_id"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-teal-200"
                            required>
                        <option value="">-- Select Patient --</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}"
                                {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->patient_id }} — {{ $p->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Doctor --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Doctor <span class="text-red-500">*</span>
                    </label>
                    <select name="doctor_id"
                            class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-teal-200"
                            required>
                        <option value="">-- Select Doctor --</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}"
                                {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->name }} — {{ $d->specialty }} (৳{{ $d->fee }})
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Appointment Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Appointment Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="date"
                           min="{{ now()->toDateString() }}"
                           value="{{ old('date', now()->toDateString()) }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-teal-200"
                           required>
                    <p class="text-xs text-gray-500 mt-1">
                        Time will be auto-assigned later by serial.
                    </p>
                    @error('date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Reason --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Reason (optional)
                    </label>
                    <textarea name="reason"
                              rows="3"
                              class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-teal-200"
                              placeholder="Short reason for visit...">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Admin payment note --}}
                <div class="bg-teal-50 border border-teal-100 rounded-lg p-4 text-sm text-teal-700">
                    <strong>Payment:</strong>
                    Admin-created appointments are assumed as
                    <span class="font-semibold">Cash / Manual Payment</span>.
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('appointments.index') }}"
                       class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                        Cancel
                    </a>

                    <button type="submit"
                            class="px-5 py-2.5 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition">
                        Create Appointment
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
