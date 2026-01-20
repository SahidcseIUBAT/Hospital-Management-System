@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-teal-50 rounded-full blur-3xl opacity-60"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Welcome Back, <span class="text-teal-600">{{ Auth::user()->name }}</span>
                    </h1>
                    <p class="text-slate-500 mt-2 text-lg">Your health journey continues here. What would you like to do today?</p>
                </div>
                
                <a href="{{ route('patient.book') }}" 
                   class="group inline-flex items-center px-8 py-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-2xl shadow-lg shadow-teal-200 transition-all duration-300 transform hover:-translate-y-1">
                    <span class="mr-3 bg-white/20 p-2 rounded-lg group-hover:bg-white/30 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </span>
                    Book New Appointment
                </a>
            </div>
        </div>

        <!-- <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="p-3 bg-rose-50 text-rose-500 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></div>
                <div><p class="text-xs text-slate-400 font-bold uppercase">Heart Rate</p><p class="font-bold text-slate-700">-- bpm</p></div>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="p-3 bg-blue-50 text-blue-500 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg></div>
                <div><p class="text-xs text-slate-400 font-bold uppercase">Weight</p><p class="font-bold text-slate-700">-- kg</p></div>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="p-3 bg-amber-50 text-amber-500 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg></div>
                <div><p class="text-xs text-slate-400 font-bold uppercase">Blood Grp</p><p class="font-bold text-slate-700">--</p></div>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                 <a href="#" class="w-full flex items-center justify-between text-teal-600 hover:text-teal-800 font-bold text-sm">
                    Update Profile <span class="text-xl">→</span>
                 </a>
            </div>
        </div> -->

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="font-bold text-xl text-slate-800 flex items-center gap-2">
                            <span class="w-2 h-2 bg-teal-500 rounded-full animate-pulse"></span>
                            Upcoming Appointments
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($upcoming as $a)
                            <div class="group flex flex-col sm:flex-row items-center justify-between p-5 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-teal-100 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center gap-4 w-full sm:w-auto">
                                    <div class="hidden sm:flex flex-col items-center justify-center w-16 h-16 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-700">
                                        <span class="text-xs font-bold uppercase text-red-500">{{ $a->scheduled_at?->format('M') }}</span>
                                        <span class="text-2xl font-black">{{ $a->scheduled_at?->format('d') }}</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-teal-600 uppercase tracking-wide">Token: #{{ $a->token }}</p>
                                        <h4 class="text-lg font-bold text-slate-800">
                                             {{ $a->doctor->name ?? ($a->doctor->user->name ?? 'Specialist') }}
                                        </h4>
                                        <p class="text-sm text-slate-500 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $a->scheduled_at?->format('h:i A') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4 sm:mt-0 w-full sm:w-auto">
                                    <span class="inline-flex justify-center w-full px-4 py-2 bg-teal-100 text-teal-700 text-sm font-bold rounded-lg">
                                        Confirmed
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <div class="inline-flex p-4 bg-slate-50 rounded-full text-slate-300 mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-slate-500 font-medium">No upcoming appointments.</p>
                                <a href="{{ route('patient.book') }}" class="text-teal-600 font-bold hover:underline mt-2 inline-block">Book one now</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50">
                        <h3 class="font-bold text-xl text-slate-800">History</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @forelse($history as $a)
                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:bg-slate-50 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                                        <div>
                                            <p class="font-bold text-slate-700 text-sm"> {{ $a->doctor->name ?? 'Doctor' }}</p>
                                            <p class="text-xs text-slate-400">{{ $a->scheduled_at?->format('d M Y, h:i A') }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-medium px-2 py-1 bg-slate-100 text-slate-500 rounded">Completed</span>
                                </div>
                            @empty
                                <p class="text-slate-400 text-sm">No appointment history found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-8">
                
                <div class="bg-indigo-900 rounded-3xl p-6 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-bold text-xl mb-1">Find a Doctor</h3>
                        <!-- <p class="text-indigo-200 text-sm mb-6">Available Departments</p>
                        
                        <div class="flex flex-wrap gap-2 mb-6">
                            @php 
                                // Mock data if categories aren't passed, replace with real loop if available
                                $specialties = ['Cardiology', 'Neurology', 'Dental', 'Pediatric', 'General']; 
                            @endphp
                            
                            
                            @foreach($specialties as $spec)
                                
                                <span
                                    class="px-3 py-1.5 bg-indigo-800/50 
                                        hover:bg-white hover:text-indigo-900 
                                        border border-indigo-700 rounded-lg 
                                        text-xs font-semibold transition-all 
                                        cursor-not-allowed">
                                    {{ $spec }}
                                </span>
                            @endforeach
                        </div> -->

                        <div class="flex gap-4 pt-6">
                <a href="{{ route('patient.doctors') }}" 
                   class="block w-full py-3 bg-white text-indigo-900 font-bold text-center rounded-xl hover:bg-indigo-50 transition">
                    ← View All Doctors
                </a>
                </div>
                
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-indigo-700 rounded-full blur-2xl opacity-50"></div>
                </div>

                @if($prescriptions->count())
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50">
                        <h3 class="font-bold text-xl text-slate-800">Prescriptions</h3>
                    </div>
                    <ul class="divide-y divide-slate-50">
                        @foreach($prescriptions as $p)
                            <li class="p-4 hover:bg-slate-50 transition flex justify-between items-center group">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">
                                         {{ $p->consultation->doctor->name ?? 'Consultant' }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $p->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                <a href="{{ route('prescriptions.show', $p) }}"
                                   class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <div class="bg-rose-50 border border-rose-100 rounded-3xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-rose-100 text-rose-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-rose-800">Need Help?</h4>
                            <p class="text-xs text-rose-600 mt-1">Contact hospital support at <br><strong>+1 800-123-4567</strong></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection