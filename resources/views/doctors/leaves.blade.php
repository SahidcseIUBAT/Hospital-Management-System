@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">My Leaves</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('doctor.leaves.store') }}"
          class="flex gap-3 mb-6">
        @csrf
        <input type="date" name="date" class="border p-2 rounded" required>
        <input type="text" name="reason" placeholder="Reason (optional)"
               class="border p-2 rounded w-full">
        <button class="bg-indigo-600 text-white px-4 rounded">Add</button>
    </form>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Date</th>
                <th class="p-2">Reason</th>
                <th class="p-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaves as $l)
            <tr class="border-t">
                <td class="p-2">{{ $l->date }}</td>
                <td class="p-2">{{ $l->reason ?? '-' }}</td>
                <td class="p-2 text-center">
                    <form method="POST"
                          action="{{ route('doctor.leaves.delete',$l) }}"
                          onsubmit="return confirm('Delete leave?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="p-4 text-center text-gray-500">
                    No leaves added
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
