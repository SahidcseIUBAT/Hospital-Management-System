@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded shadow">

    <h2 class="text-xl font-semibold mb-6 text-gray-800">Edit Doctor</h2>

    <form method="POST" action="{{ route('doctors.update', $doctor) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Name
            </label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $doctor->name) }}"
                required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
            >
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Email
            </label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $doctor->email) }}"
                required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
            >
        </div>

        <!-- Specialty -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Specialty
            </label>
            <input
                type="text"
                name="specialty"
                value="{{ old('specialty', $doctor->specialty) }}"
                required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
            >
        </div>
        <!-- Fee -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Consultation Fee (৳)    
            </label>
            <input
                type="number"
                name="fee"
                value="{{ old('fee', $doctor->fee) }}"
                min="0"
                step="0.01"
                required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
            >
        </div>

        <!-- Phone -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Phone
            </label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone', $doctor->phone) }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
            >
        </div>

        <!-- Active -->
        <div class="flex items-center gap-2">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                {{ $doctor->is_active ? 'checked' : '' }}
                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            >
            <label class="text-sm text-gray-700">Active</label>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3 pt-4">
            <a
                href="{{ route('doctors.index') }}"
                class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="px-5 py-2 bg-indigo-600 text-green-600 rounded hover:bg-indigo-700"
            >
                Update Doctor
            </button>
        </div>
    </form>
</div>
@endsection
