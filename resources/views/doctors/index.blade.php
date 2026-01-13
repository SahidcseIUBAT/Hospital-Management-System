@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Doctors</h1>

        <a href="{{ route('doctors.create') }}"
           class="px-4 py-2 bg-white text-green-600 rounded">
            Add Doctor
        </a>
    </div>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Name</th>
                <th class="border px-3 py-2">Email</th>
                <th class="border px-3 py-2">Specialty</th>
                <th class="border px-3 py-2">Status</th>
                <th class="border px-3 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($doctors as $doctor)
            <tr>
                <td class="border px-3 py-2">{{ $doctor->name }}</td>
                <td class="border px-3 py-2">{{ $doctor->user->email ?? '-' }}</td>
                <td class="border px-3 py-2">{{ $doctor->specialty }}</td>
                <td class="border px-3 py-2">
                    {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                </td>
                <td class="border px-3 py-2">
                    <a href="{{ route('doctors.edit', $doctor) }}" class="text-blue-600">Edit</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-4">No doctors found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
