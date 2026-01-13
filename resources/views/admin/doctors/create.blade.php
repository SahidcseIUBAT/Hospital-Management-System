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

                {{-- Password --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Password</label>
                    <input type="password" name="password"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- Specialty --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Specialty</label>
                    <input type="text" name="specialty"
                           class="w-full border rounded px-3 py-2"
                           value="{{ old('specialty') }}" required>
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