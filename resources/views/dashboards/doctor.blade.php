@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50/50 pb-12">
    <div class="bg-white border-b border-slate-200 sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xl">
                        Dr
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 leading-tight">
                            Dr. {{ $doctor->name ?? Auth::user()->name }}
                        </h1>
                        <p class="text-sm text-slate-500 font-medium">
                            {{ now()->format('l, d F Y') }} • <span class="text-emerald-600">On Duty</span>
                        </p>
                    </div>
                </div>

                <div class="flex gap-4 text-sm">
                    <div class="px-4 py-2 bg-slate-50 rounded-lg border border-slate-100 text-center">
                        <span class="block font-bold text-lg text-slate-800">{{ $todayAppointments->count() }}</span>
                        <span class="text-slate-500 text-xs uppercase tracking-wide">Total</span>
                    </div>
                    <div class="px-4 py-2 bg-slate-50 rounded-lg border border-slate-100 text-center">
                        <span class="block font-bold text-lg text-emerald-600">{{ $currentQueue->count() }}</span>
                        <span class="text-slate-500 text-xs uppercase tracking-wide">Waiting</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Today's Schedule
                    </h2>
                </div>

                <div class="space-y-4">
                    @forelse($todayAppointments as $a)
                        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow duration-200 relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $a->status === 'completed' ? 'bg-slate-300' : ($a->status === 'checked_in' ? 'bg-emerald-500' : 'bg-indigo-500') }}"></div>
                            
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pl-3">
                                <div class="flex items-center gap-4 w-full sm:w-auto">
                                    <div class="flex flex-col items-center justify-center w-14 h-14 bg-slate-50 rounded-lg border border-slate-100">
                                        <span class="text-[10px] uppercase font-bold text-slate-400">Token</span>
                                        <span class="text-xl font-black text-slate-800">{{ $a->token }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-lg">
                                            {{ $a->patient->user->name ?? 'Unknown Patient' }}
                                        </h3>
                                        <div class="flex items-center gap-3 text-sm text-slate-500 mt-1">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $a->scheduled_at?->format('h:i A') }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $a->status === 'checked_in' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                                {{ ucfirst(str_replace('_', ' ', $a->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                    <a href="{{ route('appointments.show', $a) }}" 
                                       class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                                        View Details
                                    </a>
                                    
                                    @if($a->status !== 'checked_in' && $a->status !== 'completed')
                                        <form action="{{ route('appointments.checkin', $a) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-all active:scale-95 flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Check In
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('consultation.start', $a) }}" 
                                           class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-sm shadow-emerald-200 transition-all active:scale-95 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Consult
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-xl border border-dashed border-slate-300">
                            <div class="mx-auto w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900">No appointments today</h3>
                            <p class="text-slate-500">Enjoy your free time, Doctor.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="space-y-6">
                
                @role('doctor')
                <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('doctor.schedule') }}" class="flex flex-col items-center justify-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition text-center group">
                            <svg class="w-6 h-6 text-indigo-600 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs font-bold text-indigo-900">My Schedule</span>
                        </a>
                        <a href="{{ route('doctor.leaves') }}" class="flex flex-col items-center justify-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition text-center group">
                            <svg class="w-6 h-6 text-amber-600 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span class="text-xs font-bold text-amber-900">Apply Leave</span>
                        </a>
                    </div>
                </div>
                @endrole

                <div class="bg-slate-900 rounded-xl p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold flex items-center gap-2">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                            Live Queue
                        </h3>
                        <span class="text-xs font-medium text-slate-400">Next Patients</span>
                    </div>

                    <div class="space-y-3">
                        @forelse($currentQueue->take(5) as $q)
                            <div class="flex items-center justify-between p-3 rounded-lg bg-white/10 border border-white/5">
                                <div class="flex items-center gap-3">
                                    <span class="font-mono text-lg font-bold text-emerald-400">#{{ $q->token }}</span>
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ $q->patient->user->name ?? 'Patient' }}</p>
                                        <p class="text-[10px] text-slate-400">Waiting since {{ $q->updated_at->format('H:i') }}</p>
                                    </div>
                                </div>
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <p class="text-slate-400 text-sm">No patients waiting in queue.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($currentQueue->count() > 5)
                        <div class="mt-4 pt-3 border-t border-white/10 text-center">
                            <span class="text-xs text-slate-400">+ {{ $currentQueue->count() - 5 }} more waiting</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection