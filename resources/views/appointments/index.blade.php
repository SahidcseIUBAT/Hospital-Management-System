@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-6">
    <h2 class="font-semibold text-xl mb-4">Appointments</h2>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-between items-center">

                {{-- ADMIN ONLY: Create Appointment --}}
                @role('admin')
                <div>
                    @if(Route::has('appointments.create'))
                    <a href="{{ route('appointments.create') }}"
                    class="px-2 py-1 bg-white text-blue-600 rounded text-sm">
                        Create Appointment
                    </a>
                @endif
                </div>

                @endrole

                <div>
                    <form action="{{ route('appointments.index') }}" method="GET"
                          class="flex gap-2 items-center">
                        <input type="search" name="q"
                               value="{{ request('q') }}"
                               placeholder="Search token / patient"
                               class="border px-2 py-1 rounded">
                        <button class="px-3 py-1 border rounded">Search</button>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium">Token</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">Scheduled</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y">
                        @forelse($appointments as $a)
                        <tr>
                            <td class="px-6 py-4">{{ $a->token }}</td>
                            <td class="px-6 py-4">
                                {{ $a->patient->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $a->doctor->name ?? 'Doctor' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $a->scheduled_at?->format('Y-m-d H:i') ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ ucfirst($a->status) }}
                            </td>

                            <td class="px-6 py-4 space-x-2">

                                {{-- View (ALL roles) --}}
                                <a href="{{ route('appointments.show', $a) }}"
                                   class="px-2 py-1 border rounded text-sm text-blue-600">
                                    View
                                </a>

                                {{-- ADMIN ONLY --}}
                                @role('admin')
                                    <a href="{{ route('appointments.edit', $a) }}"
                                       class="px-2 py-1 border rounded text-sm text-yellow-700">
                                        Edit
                                    </a>

                                    <form action="{{ route('appointments.checkin', $a) }}"
                                          method="POST" class="inline-block">
                                        @csrf
                                        <button class="px-2 py-1 bg-green-600 text-white rounded text-sm">
                                            Check In
                                        </button>
                                    </form>

                                    <form action="{{ route('appointments.destroy', $a) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Delete this appointment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1 bg-red-600 text-white rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                @endrole

                                {{-- DOCTOR ONLY (future) --}}
                                @role('doctor')
                                    <span class="text-xs text-gray-500">
                                        Assigned
                                    </span>
                                @endrole

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4">
                                No appointments yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $appointments->links() }}
            </div>

        </div>
    </div>
</div>

@endsection
