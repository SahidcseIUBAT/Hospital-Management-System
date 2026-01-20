@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-4xl mx-auto bg-gray-50 min-h-screen">
    
    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">
                    Prescription <span class="text-indigo-600 font-semibold">#{{ $prescription->consultation->appointment->token }}</span>
                </h2>
                <div class="grid grid-cols-2 gap-3 text-sm text-gray-600">
                    <div><strong>Patient:</strong> {{ $prescription->consultation->patient->user->name ?? 'N/A' }}</div>
                    <div><strong>Doctor:</strong> {{ $prescription->consultation->doctor->name ?? 'Doctor' }}</div>
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    <span>Date: {{ $prescription->created_at->format('d M Y, h:i A') }}</span>
                    @if($prescription->consultation->follow_up_at)
                        <span> | Follow-up: {{ $prescription->consultation->follow_up_at->format('M d, Y') }}</span>
                    @endif
                </div>
            </div>
            <a href="{{ route('prescriptions.print', $prescription) }}" 
               target="_blank"
               class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v.01" />
                </svg>
                Print PDF
            </a>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
        
        <!-- Clinical Info - Previous Vitals Design Restored -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-4 border-b border-gray-100">
            @if($prescription->consultation->diagnosis)
                <div class="p-3 bg-purple-50 border border-purple-100 rounded-lg">
                    <div class="text-xs font-medium text-purple-800 mb-1">Diagnosis</div>
                    <div class="text-sm font-medium text-gray-900 line-clamp-2">{{ Str::limit($prescription->consultation->diagnosis, 80) }}</div>
                </div>
            @endif

            @if($prescription->consultation->vitals && (array_filter($prescription->consultation->vitals)))
                <div class="p-3 bg-green-50 border border-green-100 rounded-lg">
                    <div class="text-xs font-medium text-green-800 mb-1">Vitals</div>
                    <div class="text-xs space-y-1">
                        @if($prescription->consultation->vitals['bp'])BP: <strong>{{ $prescription->consultation->vitals['bp'] }}</strong>@endif
                        @if($prescription->consultation->vitals['pulse']) | Pulse: <strong>{{ $prescription->consultation->vitals['pulse'] }}</strong>@endif
                    </div>
                </div>
            @endif

            @if($prescription->advice)
                <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-lg">
                    <div class="text-xs font-medium text-emerald-800 mb-1">Instructions</div>
                    <div class="text-xs line-clamp-2">{{ Str::limit($prescription->advice, 60) }}</div>
                </div>
            @endif
        </div>

        <!-- Medicines Table - More Precise & Compact -->
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-2.646 2.646a1.5 1.5 0 01-2.121 0l-2.646-2.646a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Medicines ({{ $prescription->items->count() }})
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200 text-sm rounded-lg overflow-hidden shadow-sm">
                    <thead class="bg-gradient-to-r from-orange-50 to-orange-100 border-b-2 border-orange-200">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-800 border-r border-gray-200 w-2/5">Medicine</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-800 border-r border-gray-200 w-2/5">Dosage</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-800 border-r border-gray-200 w-1/12">Days</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-800 w-1/5">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($prescription->items as $item)
                            <tr class="hover:bg-gray-50 transition-colors bg-white">
                                <td class="px-4 py-3 font-medium text-gray-900 border-r border-gray-100">{{ $item->medicine_name }}</td>
                                <td class="px-4 py-3 text-gray-700 border-r border-gray-100">{{ $item->dosage }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="bg-orange-100 text-orange-700 font-bold px-3 py-1 rounded-full text-xs inline-block">
                                        {{ $item->days }}d
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 text-sm">
                                    @if($item->notes)
                                        {{ $item->notes }}
                                    @else
                                        <span class="italic text-gray-400">Follow dosage instructions</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500 border-t border-gray-100">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    No medicines prescribed
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('prescriptions.print', $prescription) }}" 
               target="_blank"
               class="flex-1 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-medium text-center rounded-lg shadow-sm hover:shadow-md transition-all border border-orange-500">
                Print Prescription
            </a>
            <a href="{{ route('dashboard') }}" 
               class="px-6 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg shadow-sm hover:shadow-md transition-all">
                Dashboard
            </a>
        </div>
    </div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
