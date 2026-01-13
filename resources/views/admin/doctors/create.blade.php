@extends('layouts.app')

@section('content')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Doctor
        </h2>

    <div class="py-8">
        <div class="max-w-3xl mx-auto bg-white shadow rounded p-6">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('doctors.store') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Doctor Name</label>
                    <input type="text" name="name"
                           class="w-full border rounded px-3 py-2"
                           value="{{ old('name') }}" required>
                </div>

                {{-- Email (for user account) --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Email</label>
                    <input type="email" name="email"
                           class="w-full border rounded px-3 py-2"
                           value="{{ old('email') }}" required>
                </div>

                {{-- Replace password section with this --}}
<div class="group">
    <label class="block text-sm font-bold text-gray-700 mb-3 tracking-wide">Doctor PIN (6 digits)</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
            </svg>
        </div>
        <input type="password" 
               name="password" 
               maxlength="6" 
               pattern="[0-9]{6}"
               class="w-full pl-12 pr-4 py-4 bg-white/50 border-2 border-gray-200 hover:border-indigo-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/50 rounded-2xl shadow-sm transition-all duration-300 text-lg placeholder-gray-400 font-mono tracking-wider text-center" 
               placeholder="123456" 
               required>
        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
            <span class="text-sm text-gray-500">6 digits</span>
        </div>
    </div>
    <p class="mt-2 text-xs text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg inline-flex items-center">
        Simple 6-digit PIN for doctor login (e.g., 123456)
    </p>
</div>

                {{-- Specialty --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Specialty</label>
                    <input type="text" name="specialty"
                           class="w-full border rounded px-3 py-2"
                           value="{{ old('specialty') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Consultation Fee (৳)</label>
                    <input type="number" 
                        name="fee" 
                        value="{{ old('fee', $doctor->fee ?? '') }}" 
                        step="0.01" 
                        min="0" 
                        class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 rounded-lg px-4 py-2" 
                        placeholder="500" 
                        required>
                    @error('fee')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Phone --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Phone (optional)</label>
                    <input type="text" name="phone"
                           class="w-full border rounded px-3 py-2"
                           value="{{ old('phone') }}">
                </div>

                {{-- Active --}}
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="is_active" value="1"
                           class="mr-2" checked>
                    <label>Active (visible for appointments)</label>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <a href="{{ route('doctors.index') }}"
                       class="px-4 py-2 mr-2 border rounded">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded">
                        Save Doctor
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection