@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-teal-700">
            Live Appointment Queue
        </h2>

        <span class="text-sm text-gray-500">
            Auto-updates in real time
        </span>
    </div>

    <!-- Status legend -->
    <div class="flex gap-3 mb-4 text-sm">
        <span class="px-3 py-1 rounded bg-blue-50 text-blue-700">Booked</span>
        <span class="px-3 py-1 rounded bg-amber-50 text-amber-700">Checked In</span>
        <span class="px-3 py-1 rounded bg-green-50 text-green-700">Completed</span>
    </div>

    <!-- Queue list -->
    <div id="queue-list" class="space-y-3">

        @forelse($appointments as $a)
            <div class="flex items-center justify-between p-4 border rounded-lg bg-white shadow-sm">

                <div>
                    <div class="font-semibold text-gray-800">
                        {{ $a->token }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $a->patient->user->name ?? 'Patient' }}
                    </div>
                </div>

                <div>
                    <span class="px-3 py-1 text-sm rounded-full
                        @if($a->status === 'booked') bg-blue-600 text-blue-700
                        @elseif($a->status === 'checked_in')
                        @elseif($a->status === 'completed')
                        @else 
                        @endif
                    ">
                        {{ ucfirst(str_replace('_',' ',$a->status)) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-10">
                No active appointments in queue.
            </div>
        @endforelse

    </div>
</div>

<!-- Live Updates -->
<script type="module">
    import Echo from 'laravel-echo';
    import Pusher from 'pusher-js';

    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
    });

    window.Echo.channel('appointments-queue')
        .listen('.AppointmentStatusChanged', (e) => {

            const appt = e.appointment;

            const el = document.createElement('div');
            el.className =
                "flex items-center justify-between p-4 border rounded-lg bg-green-50 shadow-sm animate-pulse";

            el.innerHTML = `
                <div>
                    <div class="font-semibold text-gray-800">${appt.token}</div>
                    <div class="text-sm text-gray-500">${appt.patient.user.name}</div>
                </div>
                <div>
                    <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700">
                        ${appt.status.replace('_',' ')}
                    </span>
                </div>
            `;

            document.getElementById('queue-list').prepend(el);
        });
</script>
@endsection
