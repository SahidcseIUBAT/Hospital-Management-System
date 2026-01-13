@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Dashboard</h1>

    <p>You're logged in!</p>

    

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Top quick cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('patients.index') }}" class="p-4 bg-white shadow rounded hover:shadow-lg transition">
                    <div class="text-sm text-gray-500">Total Patients</div>
                    <div class="text-2xl font-bold">{{ $totalPatients ?? 0 }}</div>
                </a>

                <a href="{{ route('appointments.index') }}" class="p-4 bg-white shadow rounded hover:shadow-lg transition">
                    <div class="text-sm text-gray-500">Today's Appointments</div>
                    <div class="text-2xl font-bold">{{ $todaysAppointments ?? 0 }}</div>
                </a>

                <a href="{{ route('appointments.queue') }}" class="p-4 bg-white shadow rounded hover:shadow-lg transition">
                    <div class="text-sm text-gray-500">Waiting</div>
                    <div class="text-2xl font-bold text-amber-600">{{ $waiting ?? 0 }}</div>
                </a>

                <a href="{{ route('appointments.index') }}" class="p-4 bg-white shadow rounded hover:shadow-lg transition">
                    <div class="text-sm text-gray-500">Checked In</div>
                    <div class="text-2xl font-bold text-green-600">{{ $checkedIn ?? 0 }}</div>
                </a>
            </div>

            {{-- Actions --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-medium">Quick Actions</h3>
                        <p class="text-sm text-gray-500">Create or manage patients and appointments</p>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('patients.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Add Patient</a>
                        <a href="{{ route('appointments.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">Create Appointment</a>
                        <a href="{{ route('appointments.queue') }}" class="px-3 py-2 bg-green-600 text-white rounded">Live Queue</a>
                    </div>
                </div>
            </div>

            {{-- Recent appointments list --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h4 class="font-medium mb-3">Recent Appointments</h4>

                @if($recentAppointments && $recentAppointments->count())
                    <div class="space-y-2">
                        @foreach($recentAppointments as $a)
                            <div class="p-3 border rounded flex items-center justify-between">
                                <div>
                                    <div class="font-semibold">{{ $a->token }} — {{ $a->patient->user->name ?? 'Patient' }}</div>
                                    <div class="text-sm text-gray-500">{{ $a->doctor->name ?? ($a->doctor->user->name ?? 'Doctor') }} — {{ $a->scheduled_at ? \Carbon\Carbon::parse($a->scheduled_at)->format('Y-m-d H:i') : '-' }}</div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('appointments.show', $a) }}" class="px-2 py-1 border rounded text-sm text-blue-600">View</a>
                                    <form action="{{ route('appointments.checkin', $a) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="px-2 py-1 bg-green-600 text-white rounded text-sm">Check In</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500">No recent appointments.</div>
                @endif
            </div>

        </div>
    </div>
@endsection