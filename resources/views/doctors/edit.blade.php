@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-2xl mx-auto sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Doctor</h1>
        <p class="mt-1 text-sm text-gray-600">Update doctor profile information</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
        {{-- Errors --}}
        @if ($errors->any())
            <div class="p-6 bg-red-50 border-b border-red-200">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-red-800 mb-1">Please fix:</h3>
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('doctors.update', $doctor) }}" class="p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Doctor Name *</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $doctor->name) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" 
                           required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $doctor->email) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" 
                           required>
                </div>

                {{-- Specialty --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Specialty *</label>
                    <input type="text" 
                           name="specialty" 
                           value="{{ old('specialty', $doctor->specialty) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" 
                           required>
                </div>

                {{-- Fee --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Consultation Fee (৳) *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-lg font-semibold text-gray-500">৳</span>
                        <input type="number" 
                               name="fee" 
                               value="{{ old('fee', $doctor->fee) }}" 
                               step="0.01" min="0"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all" 
                               required>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                    <input type="tel" 
                           name="phone" 
                           value="{{ old('phone', $doctor->phone) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                </div>

                {{-- Status --}}
                <!-- <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-teal-500" 
                               {{ $doctor->is_active ? 'checked' : '' }}>
                        <span class="ml-3 text-sm font-semibold text-gray-700">Active Doctor</span>
                    </label>
                </div>
            </div> -->
            <div class="flex items-center">
    <label class="flex items-center">
        <input type="checkbox"
               name="is_active"
               value="1"
               class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-teal-500"
               {{ $doctor->is_active ? 'checked' : '' }}>
        <span class="ml-3 text-sm font-semibold text-gray-700">
            Active Doctor
        </span>
    </label>
</div>


            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('doctors.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors flex-1 sm:w-auto text-center">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all flex-1 sm:w-auto text-center">
                    Update Doctor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
