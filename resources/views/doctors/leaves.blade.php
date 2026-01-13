@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-4xl mx-auto sm:px-6 lg:px-8">
    {{-- Header with Back Button --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ url()->previous() }}" 
           class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-900 font-medium hover:bg-gray-100 rounded-lg transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Leaves</h1>
                <p class="text-gray-600">Mark unavailable dates for patient scheduling</p>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl mb-8">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Add Leave Form --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Add Leave Date
        </h3>
        
        <form method="POST" action="{{ route('doctor.leaves.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-end">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Leave Date <span class="text-red-500">*</span></label>
                <input type="date" 
                       name="date" 
                       value="{{ old('date') }}" 
                       min="{{ now()->format('Y-m-d') }}"
                       max="{{ now()->addYear()->format('Y-m-d') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all" 
                       required>
                @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="lg:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Reason (Optional)</label>
                <input type="text" 
                       name="reason" 
                       value="{{ old('reason') }}" 
                       placeholder="Family emergency, Seminar, Personal leave..."
                       maxlength="100"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                @error('reason') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit" 
                        class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Leave
                </button>
            </div>
        </form>
    </div>

    {{-- Leaves Table --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 border-b border-orange-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Leave Calendar ({{ $leaves->count() }} dates)
            </h3>
        </div>

        @if($leaves->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Day</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Reason</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($leaves as $l)
                            @php
                                $leaveDate = \Carbon\Carbon::parse($l->date);
                                $dayName = $leaveDate->format('l');
                            @endphp
                            <tr class="hover:bg-orange-50/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    <div class="flex flex-col">
                                        <span class="text-lg">{{ $leaveDate->format('M d, Y') }}</span>
                                        <span class="text-sm text-gray-500">{{ $leaveDate->format('D') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-3 py-1 bg-orange-100 text-orange-800 text-sm font-semibold rounded-full">
                                        {{ $dayName }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900 max-w-md">
                                        {{ $l->reason ?: 'Personal Leave' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" action="{{ route('doctor.leaves.delete', $l) }}" class="inline" 
                                          onsubmit="return confirm('Delete leave on {{ $leaveDate->format('M d, Y') }} ({{ $dayName }})?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 font-semibold text-sm px-4 py-2 rounded-lg hover:bg-red-50 transition-all flex items-center mx-auto gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No leaves scheduled</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">Add leave dates to automatically block patient appointments on those days.</p>
                <div class="flex gap-3 justify-center flex-wrap">
                    <span class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg">No leaves needed</span>
                    <span class="px-4 py-2 bg-emerald-100 text-emerald-700 text-sm rounded-lg">Always available</span>
                </div>
            </div>
        @endif
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="mt-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl">
            <div class="font-semibold mb-2">Please fix:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
