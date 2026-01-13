@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">My Availability</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add schedule -->
    <form method="POST" action="{{ route('doctor.schedule.store') }}"
          class="grid grid-cols-4 gap-3 mb-6">
        @csrf

        <select name="day" class="border p-2 rounded" required>
            <option value="">Day</option>
            @foreach(['sunday','monday','tuesday','wednesday','thursday','friday','saturday'] as $d)
                <option value="{{ $d }}">{{ ucfirst($d) }}</option>
            @endforeach
        </select>

        <input type="time" name="start_time" class="border p-2 rounded" required>
        <input type="time" name="end_time" class="border p-2 rounded" required>

        <button class="bg-indigo-600 text-white rounded px-4">
            Add
        </button>
    </form>

    <!-- Schedule list -->
    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Day</th>
                <th class="p-2">From</th>
                <th class="p-2">To</th>
                <th class="p-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $s)
            <tr class="border-t">
                <td class="p-2">{{ ucfirst($s->day) }}</td>
                <td class="p-2 text-center">{{ $s->start_time }}</td>
                <td class="p-2 text-center">{{ $s->end_time }}</td>
                <td class="p-2 text-center">
                    <form method="POST"
                          action="{{ route('doctor.schedule.delete',$s) }}"
                          onsubmit="return confirm('Delete this schedule?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">
                    No schedule added
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($errors->any())
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        @foreach($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    </div>
@endif

</div>
@endsection
