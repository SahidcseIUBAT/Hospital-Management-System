@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-6xl mx-auto sm:px-6 lg:px-8">
    {{-- Header with Back Button --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-900 font-medium hover:bg-gray-100 rounded-lg transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Doctors ({{ $doctors->count() }})</h1>
            </div>
        </div>
        <a href="{{ route('doctors.create') }}" 
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 font-semibold rounded-lg shadow-sm hover:shadow-md transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Doctor
        </a>
    </div>

    {{-- Doctors Table --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider w-56">Doctor</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Specialty</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Fee</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($doctors as $doctor)
                        <tr class="hover:bg-emerald-50/30 transition-colors">
                            {{-- Doctor --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-base text-gray-900 leading-tight">{{ Str::limit($doctor->name, 25) }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Specialty --}}
                            <td class="px-4 py-4">
                                <span class="inline-flex px-3 py-1.5 bg-emerald-100 text-emerald-800 text-sm font-medium rounded-lg">
                                    {{ Str::limit($doctor->specialty, 18) }}
                                </span>
                            </td>

                            {{-- Email --}}
                            <td class="px-4 py-4">
                                <div class="text-sm text-gray-900 max-w-[160px] truncate">
                                    {{ $doctor->user->email ?? '-' }}
                                </div>
                            </td>

                            {{-- Fee --}}
                            <td class="px-4 py-4">
                                <div class="font-bold text-base text-emerald-700">
                                    ৳{{ number_format($doctor->fee ?? 0, 0) }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold
                                    {{ $doctor->is_active ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-700 border border-gray-200' }}">
                                    {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- Action --}}
                            <td class="px-4 py-4">
                                <a href="{{ route('doctors.edit', $doctor) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition-all shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-20 h-20 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No doctors found</h3>
                                    <p class="text-gray-600 mb-6">Get started by adding your first doctor.</p>
                                    <a href="{{ route('doctors.create') }}" 
                                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-lg font-semibold shadow-sm hover:shadow-md transition-all">
                                        Add First Doctor
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- FIXED Pagination --}}
        @if(isset($doctors) && method_exists($doctors, 'hasPages') && $doctors->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $doctors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
