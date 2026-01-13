@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-2xl mx-auto sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-teal-100 rounded-lg flex items-center justify-center">
                <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Appointment</h1>
                <p class="text-sm text-gray-500 mt-1 font-mono bg-gray-100 inline-block px-2 py-1 rounded">
                    Token: {{ $appointment->token }}
                </p>
            </div>
        </div>
    </div>

    {{-- Error Alert --}}
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span class="text-sm font-medium text-red-800">Please fix the following errors:</span>
            </div>
            <ul class="mt-2 ml-6 space-y-1 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Patient --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Patient <span class="text-red-500">*</span>
                    </label>
                    <select name="patient_id" class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-2 transition-all duration-200" required>
                        <option value="">-- Select Patient --</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ old('patient_id', $appointment->patient_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->patient_id ?? 'N/A' }} - {{ $p->user->name ?? 'Patient' }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Doctor --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Doctor <span class="text-red-500">*</span>
                    </label>
                    <select name="doctor_id" class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-2 transition-all duration-200" required>
                        <option value="">-- Select Doctor --</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}" {{ old('doctor_id', $appointment->doctor_id) == $d->id ? 'selected' : '' }}>
                                {{ $d->name }} ({{ $d->specialty ?? 'General' }})
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Scheduled At --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Date & Time <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                           name="scheduled_at" 
                           value="{{ old('scheduled_at', $appointment->scheduled_at?->format('Y-m-d\TH:i')) }}" 
                           class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-2 transition-all duration-200" 
                           required>
                    @error('scheduled_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-2 transition-all duration-200">
                        @foreach(['pending_payment', 'booked', 'checked_in', 'in_progress', 'completed', 'cancelled'] as $s)
                            <option value="{{ $s }}" {{ old('status', $appointment->status) == $s ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $s)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Reason --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Reason for Visit (Optional)</label>
                <textarea name="reason" rows="4" 
                          class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-2 transition-all duration-200 resize-vertical" 
                          placeholder="Enter reason for appointment...">{{ old('reason', $appointment->reason) }}</textarea>
                @error('reason')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                <button type="submit" 
                        class="flex-1 sm:w-auto bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Appointment
                </button>
                <a href="{{ route('appointments.index') }}" 
                   class="flex-1 sm:w-auto bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
