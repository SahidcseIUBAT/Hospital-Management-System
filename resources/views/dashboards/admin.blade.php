@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50/50 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Admin Command Center</h1>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    System Live: Monitoring hospital operations and staff performance.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('appointments.index') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg shadow-sm shadow-indigo-200 hover:bg-indigo-700 transition-all duration-200 active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Appointments
                </a>
                <a href="{{ route('doctors.index') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-white text-slate-700 border border-slate-200 font-semibold rounded-lg shadow-sm hover:bg-slate-50 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Manage Doctors
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 p-6 group hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Patients</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-1">{{ $totalPatients ?? 0 }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-medium text-indigo-600">
                    <span>↑ 12% from last month</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 group hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Active Doctors</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-1">{{ $totalDoctors ?? 0 }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-medium text-emerald-600">
                    <span>Fully Operational</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 group hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Scheduled Today</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-1">{{ $todaysAppointments ?? 0 }}</h3>
                    </div>
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-medium text-amber-600">
                    <span>Peak hours: 10AM - 2PM</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 group hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Current Queue</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-1">{{ $queueToday ?? 0 }}</h3>
                    </div>
                    <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-medium text-rose-600">
                    <span>Live status: Processing</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">Appointment Analytics</h3>
                    <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-3 py-1 rounded-full">{{ now()->year }} Annual Data</span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                        @foreach(range(1,12) as $m)
                            <div class="group flex flex-col items-center p-4 rounded-xl border border-slate-50 hover:border-indigo-100 hover:bg-indigo-50/30 transition-all duration-200">
                                <span class="text-xs font-semibold text-slate-400 uppercase">{{ \Carbon\Carbon::create()->month($m)->format('M') }}</span>
                                <span class="text-xl font-bold text-slate-700 mt-1 group-hover:text-indigo-600">{{ $monthly[$m] ?? 0 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-5">Administrative Tools</h3>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('patients.index') }}" class="group flex items-center p-3 rounded-xl border border-slate-100 hover:bg-slate-50 transition-all">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <span class="font-semibold text-slate-700">Patient Database</span>
                        </a>

                        <a href="{{ route('doctors.index') }}" class="group flex items-center p-3 rounded-xl border border-slate-100 hover:bg-slate-50 transition-all">
                            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <span class="font-semibold text-slate-700">Manage Doctors</span>
                        </a>

                        <a href="{{ route('appointments.queue') }}" class="group flex items-center p-3 rounded-xl border border-slate-100 hover:bg-slate-50 transition-all">
                            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="font-semibold text-slate-700">Live Queue Monitor</span>
                        </a>

                        <a href="#" class="group flex items-center p-3 rounded-xl border border-indigo-100 bg-indigo-50/50 hover:bg-indigo-50 transition-all">
                            <div class="w-10 h-10 rounded-lg bg-indigo-600 text-white flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            </div>
                            <span class="font-semibold text-indigo-900">System Settings</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-200">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-500 font-medium">
                <p>&copy; {{ now()->year }} Smart Hospital Management. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-indigo-600 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">Support Center</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">System Logs</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection