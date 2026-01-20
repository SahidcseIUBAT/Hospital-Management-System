@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-2xl mx-auto sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-8 text-center">
        <div class="w-16 h-16 bg-teal-100 rounded-xl mx-auto mb-6 flex items-center justify-center">
            <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Add New Doctor</h1>
        <p class="text-gray-600">Create doctor profile for appointment booking system</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="p-6 bg-red-50 border-b border-red-200">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Please fix the following:</h3>
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('doctors.store') }}" class="p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Doctor Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-3 transition-all duration-200" 
                           placeholder="Dr. Ahmed Rahman" 
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-3 transition-all duration-200" 
                           placeholder="doctor@example.com" 
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Specialty --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Specialty <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="specialty" 
                           value="{{ old('specialty') }}" 
                           class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-3 transition-all duration-200" 
                           placeholder="Cardiology, Pediatrics, etc." 
                           required>
                    @error('specialty')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Consultation Fee --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Consultation Fee (৳) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-lg font-semibold text-gray-500">৳</span>
                        </div>
                        <input type="number" 
                               name="fee" 
                               value="{{ old('fee') }}" 
                               step="0.01" 
                               min="0" 
                               max="100000"
                               class="w-full pl-10 border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-3 transition-all duration-200" 
                               placeholder="500" 
                               required>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Enter consultation fee per visit</p>
                    @error('fee')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <input type="tel" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-3 transition-all duration-200" 
                           placeholder="+880 17XX XXX XXX">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 rounded-lg px-4 py-3 transition-all duration-200" 
                           placeholder="••••••••" 
                           required>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Active Status --}}
            <!-- <div class="mb-8">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="h-5 w-5 text-teal-600 focus:ring-teal-500 border-gray-300 rounded" checked>
                    <span class="ml-3 text-sm font-semibold text-gray-700">Active Doctor (Visible for booking)</span>
                </label>
                <p class="mt-1 text-xs text-gray-500 ml-8">Inactive doctors won't appear in patient booking lists</p>
            </div> -->
            <div class="mb-8">
    <label class="flex items-center">
        <input type="checkbox"
               name="is_active"
               value="1"
               class="h-5 w-5 text-teal-600 focus:ring-teal-500 border-gray-300 rounded"
               checked>
        <span class="ml-3 text-sm font-semibold text-gray-700">
            Active Doctor (Visible for booking)
        </span>
    </label>
    <p class="mt-1 text-xs text-gray-500 ml-8">
        Inactive doctors won't appear in patient booking lists
    </p>
</div>


            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200 bg-gray-50 px-2 sm:px-0">
                <a href="{{ route('doctors.index') }}" 
                   class="flex-1 sm:w-auto bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 sm:w-auto bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Doctor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
