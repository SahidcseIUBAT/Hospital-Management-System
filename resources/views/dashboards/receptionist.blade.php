@extends('layouts.app')

@section('content')
<h2 class="font-semibold text-xl">Receptionist Dashboard</h2>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-white shadow rounded">
                <div class="text-sm text-gray-500">Waiting</div>
                <div class="text-2xl font-bold">{{ $waiting ?? 0 }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded">
                <div class="text-sm text-gray-500">Checked In</div>
                <div class="text-2xl font-bold">{{ $checkedIn ?? 0 }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded">
                <a href="{{ route('appointments.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">Create Appointment</a>
            </div>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold">Recent Appointments</h3>
            <div class="mt-3 space-y-2">
                @foreach($recentAppointments as $a)
                    <div class="p-2 border rounded">{{ $a->token }} — {{ $a->patient->user->name ?? 'Patient' }} — {{ $a->status }}</div>
                @endforeach
            </div>
        </div>
    </div>
@endsection