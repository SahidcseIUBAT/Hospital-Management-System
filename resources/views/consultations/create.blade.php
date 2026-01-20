@extends('layouts.app')

@section('content')
<div class="py-12 px-4 max-w-6xl mx-auto bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    
    <!-- Header Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 mb-8 p-8">
        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        Consultation
                    </h1>
                    <span class="text-xl font-semibold text-gray-600 bg-gray-100 px-4 py-1 rounded-full">
                        #{{ $appointment->token }}
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-center gap-2 p-3 bg-blue-50 rounded-xl">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $appointment->patient->user->name ?? 'N/A' }}</div>
                            <div class="text-gray-500">Patient</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 p-3 bg-green-50 rounded-xl">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Dr. {{ $appointment->doctor->name ?? 'Doctor' }}</div>
                            <div class="text-gray-500">Physician</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 p-3 bg-purple-50 rounded-xl">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $appointment->scheduled_at?->format('M d, Y h:i A') }}</div>
                            <div class="text-gray-500">Scheduled</div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('appointments.show', $appointment) }}" 
               class="px-8 py-3 border border-gray-300 text-gray-700 bg-white/50 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm flex items-center gap-2">
                ← Back to Appointment
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-8 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <ul class="list-disc list-inside text-red-800 text-sm mt-1 space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('consultations.store', $appointment) }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column (1/3) - Patient Data -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Chief Complaint -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Chief Complaint</label>
                    <input type="text" name="chief_complaint" value="{{ old('chief_complaint') }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                           placeholder="Describe patient's primary complaint...">
                </div>
                

                
                <!-- Vitals -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                        📊 Vital Signs
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Blood Pressure</label>
                            <input type="text" name="vitals[bp]" value="{{ old('vitals.bp') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                   placeholder="e.g., 120/80 mmHg">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Pulse (bpm)</label>
                            <input type="number" name="vitals[pulse]" value="{{ old('vitals.pulse') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                   placeholder="e.g., 72">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Temperature (°F)</label>
                            <input type="number" step="0.1" name="vitals[temp]" value="{{ old('vitals.temp') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                   placeholder="e.g., 98.6">
                        </div>
                    </div>
                    
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <label class="block text-sm font-semibold text-gray-900 mb-3">Diagnosis</label>
                        <textarea name="diagnosis" rows="5" 
                                  class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 resize-vertical"
                                  placeholder="e.g., Acute upper respiratory infection, Hypertension, Type 2 diabetes">{{ old('diagnosis') }}</textarea>
                    </div>
            </div>

            <!-- Right Column (2/3) - Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Diagnosis & Notes -->

                <!-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6"> -->
                    <!-- <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <label class="block text-sm font-semibold text-gray-900 mb-3">Diagnosis</label>
                        <textarea name="diagnosis" rows="5" 
                                  class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 resize-vertical"
                                  placeholder="e.g., Acute upper respiratory infection, Hypertension, Type 2 diabetes">{{ old('diagnosis') }}</textarea>
                    </div> -->
                    <!-- <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <label class="block text-sm font-semibold text-gray-900 mb-3">Clinical Notes</label>
                        <textarea name="notes" rows="5" 
                                  class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 resize-vertical"
                                  placeholder="e.g., Patient alert, good air entry, no distress, abdomen soft">{{ old('notes') }}</textarea>
                    </div>
                </div> -->

                <!-- PRESCRIPTION SECTION - MAIN FOCUS (Full width of right column) -->
                <div class="bg-white rounded-2xl border-2 border-orange-200 shadow-lg p-8">
                    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-orange-200">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-2.646 2.646a1.5 1.5 0 01-2.121 0l-2.646-2.646a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">PRESCRIPTION</h2>
                            <div class="text-sm text-gray-600">Medication Orders</div>
                        </div>
                    </div>

                    <!-- Prescription Items -->
                    <div id="prescription-items" class="space-y-4 max-h-96 overflow-y-auto mb-8 pr-2">
                        <div class="pres-item bg-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-md transition-all">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Medicine Name</label>
                                    <input type="text" name="medicine_name[]" placeholder="e.g., Paracetamol 500mg Tablet" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 font-medium">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Dosage Instructions</label>
                                    <input type="text" name="dosage[]" placeholder="e.g., 1 tablet twice daily after meals" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 font-medium">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Duration</label>
                                    <input type="number" min="1" name="days[]" placeholder="No. of days" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 text-center font-semibold">
                                </div>
                                <div class="lg:col-span-3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Special Instructions</label>
                                    <input type="text" name="item_notes[]" placeholder="e.g., Take with food, avoid alcohol" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prescription Controls -->
                    <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-200">
                        <button type="button" id="add-item" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Medicine
                        </button>
                        <button type="button" id="remove-item" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2 border border-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4" />
                            </svg>
                            Remove
                        </button>
                    </div>
                </div>

                <!-- Advice & Follow-up & Save -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                            <label class="block text-sm font-semibold text-gray-900 mb-3">Advice</label>
                            <textarea name="advice" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 resize-vertical"
                                      placeholder="e.g., Rest, plenty of fluids, healthy diet, return if fever persists">{{ old('advice') }}</textarea>
                        </div>
                    </div>
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm h-full flex flex-col">
                            <label class="block text-sm font-semibold text-gray-900 mb-3">Follow-up Date (Optional)</label>
                            <input type="date" name="follow_up_at" value="{{ old('follow_up_at') }}" 
                                   class="flex-1 px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <button type="submit" 
                                    class="mt-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Save Consultation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('prescription-items');
    
    // Add medicine row
    document.getElementById('add-item').addEventListener('click', function() {
        const node = document.querySelector('.pres-item').cloneNode(true);
        node.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(node);
        // Auto-scroll to new item
        setTimeout(() => {
            container.scrollTop = container.scrollHeight;
        }, 100);
    });
    
    // Remove last medicine row
    document.getElementById('remove-item').addEventListener('click', function() {
        const items = container.querySelectorAll('.pres-item');
        if (items.length > 1) {
            items[items.length - 1].remove();
        }
    });

    // Auto-resize textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
});
</script>

<style>
/* Clean prescription scrollbar */
#prescription-items::-webkit-scrollbar {
    width: 6px;
}
#prescription-items::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 3px;
}
#prescription-items::-webkit-scrollbar-thumb {
    background: #f97316;
    border-radius: 3px;
}
#prescription-items::-webkit-scrollbar-thumb:hover {
    background: #ea580c;
}
</style>
@endsection
