@extends('layouts.app')

@section('content')
<div class="py-6 px-4 max-w-4xl mx-auto sm:px-6 lg:px-8">
    {{-- Compact Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-2-4h.01M9 16h.01"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Live Queue</h1>
                <p class="text-sm text-gray-600">Real-time appointment counter</p>
            </div>
        </div>
        <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full font-medium">
            Auto-refreshes
        </span>
    </div>

    {{-- Status Legend --}}
    <div class="flex flex-wrap gap-2 mb-6 px-4 py-3 bg-gray-50 rounded-lg">
        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Booked</span>
        <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full">Checked In</span>
        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full">Completed</span>
        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Called</span>
    </div>

    {{-- Queue Cards --}}
    <div id="queue-list" class="space-y-2 max-h-96 overflow-y-auto">
        @forelse($appointments as $a)
        <div class="group flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-white hover:bg-gray-50 hover:border-emerald-200 transition-all duration-200 shadow-sm hover:shadow-md">
            <div class="flex items-center gap-4 flex-1 min-w-0">
                {{-- Token - BIG BOLD --}}
                <div class="flex-shrink-0">
                    <div class="text-lg font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
                        {{ $a->token }}
                    </div>
                </div>

                {{-- Patient Info --}}
                <div class="min-w-0 flex-1">
                    <div class="font-semibold text-gray-900 text-sm truncate">{{ $a->patient->user->name ?? 'Patient' }}</div>
                    <div class="text-xs text-gray-500">{{ $a->scheduled_at?->format('h:i A') }}</div>
                </div>

                {{-- Doctor --}}
                <div class="text-center hidden sm:block">
                    <div class="text-xs font-medium text-gray-900">{{ Str::limit($a->doctor->name ?? 'Dr', 10) }}</div>
                </div>
            </div>

            {{-- Status Badge --}}
            <div class="ml-4 flex-shrink-0">
                <span class="px-3 py-1.5 text-xs font-semibold rounded-full shadow-sm
                    @switch($a->status)
                        @case('booked') bg-blue-100 text-blue-800 @break
                        @case('checked_in') bg-amber-100 text-amber-800 @break
                        @case('completed') bg-emerald-100 text-emerald-800 @break
                        @case('called') bg-green-100 text-green-800 @break
                        @default bg-gray-100 text-gray-700
                    @endswitch">
                    {{ ucfirst(str_replace('_', ' ', $a->status)) }}
                </span>
            </div>
        </div>
        @empty
        <div class="text-center py-16 px-4">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Queue is empty</h3>
            <p class="text-sm text-gray-600 mb-6">Appointments appear here when patients check in</p>
        </div>
        @endforelse
    </div>

    {{-- Live Updates - FIXED --}}
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

        // Listen for appointment updates
        window.Echo.channel('appointments-queue')
            .listen('.AppointmentStatusChanged', (e) => {
                const appt = e.appointment;
                const queueList = document.getElementById('queue-list');
                
                // Remove existing appointment if it exists
                const existing = queueList.querySelector(`[data-token="${appt.token}"]`);
                if (existing) {
                    existing.remove();
                }

                // Create new appointment card
                const el = document.createElement('div');
                el.setAttribute('data-token', appt.token);
                el.className = 'flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-white hover:bg-gray-50 hover:border-emerald-200 transition-all duration-200 shadow-sm hover:shadow-md';

                el.innerHTML = `
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="flex-shrink-0">
                            <div class="text-lg font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
                                ${appt.token}
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-gray-900 text-sm truncate">${appt.patient.user.name}</div>
                            <div class="text-xs text-gray-500">${appt.scheduled_at}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs font-medium text-gray-900">${appt.doctor.name}</div>
                        </div>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <span class="px-3 py-1.5 text-xs font-semibold rounded-full shadow-sm 
                            ${appt.status === 'booked' ? 'bg-blue-100 text-blue-800' : 
                              appt.status === 'checked_in' ? 'bg-amber-100 text-amber-800' : 
                              appt.status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 
                              'bg-gray-100 text-gray-700'}">
                            ${appt.status.replace('_', ' ')}
                        </span>
                    </div>
                `;

                // Add to top of queue
                queueList.insertBefore(el, queueList.firstChild);

                // Remove if completed (optional - keep for records)
                if (appt.status === 'completed') {
                    setTimeout(() => {
                        el.remove();
                    }, 5000);
                }

                // Scroll to top
                queueList.scrollTop = 0;
            });
    </script>
@endsection
