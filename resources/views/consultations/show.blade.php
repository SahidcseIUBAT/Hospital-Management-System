@extends('layouts.app')

@section('content')
<div class="py-8 px-6 max-w-5xl mx-auto bg-gray-50 min-h-screen">
    
    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-8 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Consultation <span class="text-lg font-semibold text-indigo-600">#{{ $consultation->appointment->token }}</span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div><strong>Patient:</strong> {{ $consultation->patient->user->name }}</div>
                    <div><strong>Doctor:</strong> {{ $consultation->doctor->name }}</div>
                    <div><strong>Started:</strong> {{ $consultation->started_at?->format('M d, Y h:i A') }}</div>
                    <div><strong>Status:</strong> 
                        @if($consultation->completed_at)
                            <span class="text-green-600 font-medium">Completed</span> 
                            ({{ $consultation->completed_at?->format('M d, Y h:i A') }})
                        @else
                            <span class="text-orange-600 font-medium">In Progress</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                @role('doctor')
                    @if(!$consultation->completed_at)
                        <form method="POST" action="{{ route('consultations.complete', $consultation) }}" 
                              onsubmit="return confirm('Complete this consultation?')" class="inline">
                            @csrf
                            <button class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg border border-green-600 shadow-sm transition-colors">
                                Complete Consultation
                            </button>
                        </form>
                    @endif
                @endrole
                <a href="{{ route('appointments.show', $consultation->appointment) }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg shadow-sm transition-colors">
                    Back to Appointment
                </a>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <ul class="list-disc pl-5 text-red-800 text-sm space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Clinical Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Chief Complaint & Vitals -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="font-semibold text-lg text-gray-900 mb-4">Clinical Summary</h3>
                
                @if($consultation->chief_complaint)
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-100 rounded-lg">
                        <div class="font-medium text-sm text-blue-800 mb-1">Chief Complaint</div>
                        <div class="text-sm text-gray-800">{{ $consultation->chief_complaint }}</div>
                    </div>
                @endif

                @if($consultation->vitals)
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                        @if($consultation->vitals['bp'])
                            <div class="bg-green-50 p-3 rounded-lg border border-green-100 text-center">
                                <div class="font-medium text-xs text-green-800">BP</div>
                                <div class="text-sm font-semibold">{{ $consultation->vitals['bp'] }}</div>
                            </div>
                        @endif
                        @if($consultation->vitals['pulse'])
                            <div class="bg-green-50 p-3 rounded-lg border border-green-100 text-center">
                                <div class="font-medium text-xs text-green-800">Pulse</div>
                                <div class="text-sm font-semibold">{{ $consultation->vitals['pulse'] }} bpm</div>
                            </div>
                        @endif
                        @if($consultation->vitals['temp'])
                            <div class="bg-green-50 p-3 rounded-lg border border-green-100 text-center">
                                <div class="font-medium text-xs text-green-800">Temp</div>
                                <div class="text-sm font-semibold">{{ $consultation->vitals['temp'] }} °F</div>
                            </div>
                        @endif
                    </div>
                @endif

                @if($consultation->diagnosis)
                    <div class="p-4 bg-purple-50 border border-purple-100 rounded-lg">
                        <div class="font-semibold text-sm text-purple-800 mb-2">Diagnosis</div>
                        <div class="text-sm text-gray-800 whitespace-pre-wrap">{{ $consultation->diagnosis }}</div>
                    </div>
                @endif

                @if($consultation->notes)
                    <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-lg">
                        <div class="font-semibold text-sm text-indigo-800 mb-2">Notes</div>
                        <div class="text-sm text-gray-800 whitespace-pre-wrap">{{ $consultation->notes }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - PRESCRIPTION (Main Focus) -->
        <div class="lg:col-span-2">
            <div class="bg-white border-2 border-orange-100 rounded-xl shadow-sm p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-2.646 2.646a1.5 1.5 0 01-2.121 0l-2.646-2.646a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    PRESCRIPTION
                </h3>

                @if($consultation->prescription)
                    @if($consultation->prescription->advice)
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-2">Patient Advice</h4>
                            <div class="text-sm text-gray-800 whitespace-pre-wrap">{{ $consultation->prescription->advice }}</div>
                        </div>
                    @endif

                    <!-- Prescription Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="w-full text-sm">
                            <thead class="bg-orange-50 border-b-2 border-orange-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-900 border-r border-gray-200">Medicine</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-900 border-r border-gray-200">Dosage</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-900 border-r border-gray-200">Days</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-900">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($consultation->prescription->items as $it)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-4 font-semibold text-gray-900 bg-gray-50">{{ $it->medicine_name }}</td>
                                        <td class="px-4 py-4 font-medium text-gray-800">{{ $it->dosage }}</td>
                                        <td class="px-4 py-4 text-center font-bold text-lg text-orange-700">{{ $it->days }}</td>
                                        <td class="px-4 py-4 text-gray-700 italic">{{ $it->notes ?: 'Follow dosage instructions' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('prescriptions.print', $consultation->prescription) }}" 
                           target="_blank"
                           class="flex-1 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-center rounded-lg shadow-sm hover:shadow-md transition-all border border-orange-500">
                            Print Prescription
                        </a>
                        <a href="{{ route('appointments.show', $consultation->appointment) }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold rounded-lg shadow-sm hover:shadow-md transition-all text-center">
                            View Appointment
                        </a>
                    </div>

                @else
                    <div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-xl">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-500 mb-2">No Prescription</h3>
                        <p class="text-gray-500">No medications were prescribed for this consultation.</p>
                    </div>
                @endif
            </div>

            @if($consultation->follow_up_at)
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-blue-800">Follow-up Appointment</div>
                            <div class="text-2xl font-bold text-blue-600">{{ $consultation->follow_up_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
