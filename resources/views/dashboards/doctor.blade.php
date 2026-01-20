@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50">
    {{-- Sticky Header --}}
    <div class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Dr. {{ $doctor->name ?? Auth::user()->name }}</h1>
                        <p class="text-sm text-slate-600 flex items-center gap-2">
                            {{ now()->format('l, F d, Y') }}
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full">On Duty</span>
                        </p>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="flex gap-4">
                    <div class="text-center p-3 bg-slate-50 rounded-xl border">
                        <div class="text-2xl font-bold text-slate-900">{{ $todayAppointments->count() }}</div>
                        <div class="text-xs text-slate-500 uppercase tracking-wider">Today</div>
                    </div>
                    <div class="text-center p-3 bg-emerald-50 rounded-xl border">
                        <div class="text-2xl font-bold text-emerald-700">{{ $currentQueue->count() }}</div>
                        <div class="text-xs text-emerald-700 uppercase tracking-wider">Queue</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {{-- Main Content --}}
            <div class="lg:col-span-3 space-y-6">
                
                {{-- Navigation Tabs --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <div class="flex border-b border-slate-200">
                            <button id="today-tab" class="flex-1 py-3 font-semibold text-sm text-slate-700 border-b-2 border-emerald-500">Today's Appointments</button>
                            <button id="all-tab" class="flex-1 py-3 font-semibold text-sm text-slate-500 hover:text-slate-700">All Appointments</button>
                        </div>
                    </div>

                    {{-- Today's Appointments --}}
                    <div id="today-content" class="space-y-1">
                        @forelse($todayAppointments as $a)
                        <div class="p-5 hover:bg-slate-50 group border-l-4 @switch($a->status)
                            @case('completed') border-slate-300 @break
                            @case('checked_in') border-emerald-500 @break
                            @case('called') border-amber-500 @break
                            @default border-blue-500
                        @endswitch">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4 flex-1">
                                    <div class="w-14 h-14 bg-slate-50 rounded-xl flex flex-col items-center justify-center p-2">
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Token</span>
                                        <span class="text-lg font-black text-slate-900">{{ substr($a->token, -3) }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-slate-900 text-base truncate">{{ $a->patient->user->name ?? 'Patient' }}</h3>
                                        <p class="text-sm text-slate-600">{{ $a->scheduled_at?->format('h:i A') }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold @switch($a->status)
                                        @case('pending') bg-blue-100 text-blue-800 @break
                                        @case('checked_in') bg-emerald-100 text-emerald-800 @break
                                        @case('called') bg-amber-100 text-amber-800 @break
                                        @case('completed') bg-slate-100 text-slate-700 @break
                                        @default bg-gray-100 text-gray-700
                                    @endswitch">
                                        {{ ucfirst(str_replace('_', ' ', $a->status)) }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <a href="{{ route('appointments.show', $a) }}" class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @if($a->status === 'checked_in' || $a->status === 'called')
                                    <a href="{{ route('consultation.start', $a) }}" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all">
                                        Consult
                                    </a>
                                    @elseif($a->status === 'pending')
                                    <form action="{{ route('appointments.checkin', $a) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="px-4 py-2 bg-emerald-500 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all">Check In</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-slate-900 mb-2">No appointments today</h3>
                            <p class="text-slate-600">Check back later for scheduled patients</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- All Appointments (Hidden by default) --}}
                    <div id="all-content" class="space-y-1 hidden">
                        @forelse($allAppointments ?? [] as $a)
                        <div class="p-5 hover:bg-slate-50 border-l-4 @switch($a->status)
                            @case('completed') border-slate-300 @break
                            @case('checked_in') border-emerald-500 @break
                            @case('called') border-amber-500 @break
                            @default border-blue-500
                        @endswitch">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-slate-50 rounded-lg flex flex-col items-center justify-center p-2">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">{{ substr($a->token, -3) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $a->patient->user->name ?? 'Patient' }}</div>
                                        <div class="text-sm text-slate-600">{{ $a->scheduled_at?->format('M d, h:i A') }}</div>
                                    </div>
                                </div>
                                <span class="px-3 py-1 @switch($a->status)
                                    @case('pending') bg-blue-100 text-blue-800 @break
                                    @case('checked_in') bg-emerald-100 text-emerald-800 @break
                                    @case('called') bg-amber-100 text-amber-800 @break
                                    @case('completed') bg-slate-100 text-slate-700 @break
                                    @default bg-gray-100 text-gray-700
                                @endswitch text-xs font-semibold rounded-full">
                                    {{ ucfirst(str_replace('_', ' ', $a->status)) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-16">
                            <p class="text-slate-600">No appointments found</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Consultations (New Feature) --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">Recent Consultations</h3>
                    @forelse($recentConsultations ?? [] as $c)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <span class="text-sm font-bold text-emerald-700">{{ substr($c->appointment->token, -3) }}</span>
                            </div>
                            <div>
                                <div class="font-medium text-slate-900">{{ $c->patient->user->name ?? 'Patient' }}</div>
                                <div class="text-xs text-slate-500">{{ $c->created_at->format('h:i A') }}</div>
                            </div>
                        </div>
                        <span class="text-xs text-emerald-700 font-semibold px-2 py-1 bg-emerald-100 rounded">Completed</span>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-500">No recent consultations</div>
                    @endforelse
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                
                {{-- Quick Actions --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 mb-6 text-sm uppercase tracking-wider pb-2 border-b">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('doctor.schedule') }}" class="flex items-center p-4 hover:bg-slate-50 rounded-xl group transition-all">
                            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-indigo-200">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900">My Schedule</div>
                                <div class="text-sm text-slate-500">Set availability</div>
                            </div>
                        </a>
                        <a href="{{ route('doctor.leaves') }}" class="flex items-center p-4 hover:bg-slate-50 rounded-xl group transition-all">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-orange-200">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900">Apply Leave</div>
                                <div class="text-sm text-slate-500">Mark unavailable dates</div>
                            </div>
                        </a>
                        <a href="{{ route('appointments.index') }}" class="flex items-center p-4 hover:bg-slate-50 rounded-xl group transition-all">
                            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-emerald-200">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900">All Appointments</div>
                                <div class="text-sm text-slate-500">View complete list</div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Clean Live Queue --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-bold text-slate-900 flex items-center gap-2">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                            Live Queue
                        </h3>
                        <span class="text-sm font-semibold text-slate-700 bg-slate-100 px-3 py-1 rounded-full">
                            {{ $currentQueue->count() }} waiting
                        </span>
                    </div>
                    <div class="space-y-3 max-h-72 overflow-y-auto">
                        @forelse($currentQueue->take(5) as $q)
                        <div class="flex items-center justify-between p-4 bg-emerald-50/50 border border-emerald-100 rounded-xl group hover:bg-emerald-50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-emerald-200 rounded-lg flex items-center justify-center">
                                    <span class="font-bold text-sm text-emerald-700">{{ substr($q->token, -3) }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="font-semibold text-slate-900 text-sm truncate">{{ $q->patient->user->name ?? 'Patient' }}</div>
                                    <div class="text-xs text-slate-500">Waiting {{ $q->updated_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                            </svg>
                            <p class="text-slate-500 text-sm">No patients waiting</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tab JavaScript --}}
    <script>
        document.getElementById('today-tab').addEventListener('click', function() {
            document.getElementById('today-tab').classList.add('border-emerald-500', 'text-slate-700');
            document.getElementById('today-tab').classList.remove('text-slate-500');
            document.getElementById('all-tab').classList.add('text-slate-500');
            document.getElementById('all-tab').classList.remove('border-emerald-500', 'text-slate-700');
            document.getElementById('today-content').classList.remove('hidden');
            document.getElementById('all-content').classList.add('hidden');
        });

        document.getElementById('all-tab').addEventListener('click', function() {
            document.getElementById('all-tab').classList.add('border-emerald-500', 'text-slate-700');
            document.getElementById('all-tab').classList.remove('text-slate-500');
            document.getElementById('today-tab').classList.add('text-slate-500');
            document.getElementById('today-tab').classList.remove('border-emerald-500', 'text-slate-700');
            document.getElementById('all-content').classList.remove('hidden');
            document.getElementById('today-content').classList.add('hidden');
        });
    </script>
@endsection
