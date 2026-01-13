@extends('layouts.app')

@section('content')

<h2 class="text-xl mb-4">Doctors</h2>
<a href="{{ route('admin.doctors.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">Add Doctor</a>

<table class="w-full mt-4">
<tr>
  <th>Name</th><th>Specialty</th><th>Phone</th><th>Status</th><th>Action</th>
</tr>
@foreach($doctors as $doctor)
<tr>
  <td>{{ $doctor->name }}</td>
  <td>{{ $doctor->specialty }}</td>
  <div class="mb-4">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Consultation Fee (৳)</label>
    <input type="number" 
           name="fee" 
           value="{{ old('fee', $doctor->fee ?? '') }}" 
           step="0.01" 
           min="0" 
           class="w-full border border-gray-300 focus:ring-2 focus:ring-teal-500 rounded-lg px-4 py-2" 
           placeholder="500" 
           required>
    @error('fee')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

  <td>{{ $doctor->phone }}</td>
  <td>{{ $doctor->is_active ? 'Active' : 'Inactive' }}</td>
  <td>
    <a href="{{ route('admin.doctors.edit',$doctor) }}">Edit</a>
  </td>
</tr>
@endforeach
</table>
@endsection