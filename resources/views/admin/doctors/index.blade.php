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
  <td>{{ $doctor->phone }}</td>
  <td>{{ $doctor->is_active ? 'Active' : 'Inactive' }}</td>
  <td>
    <a href="{{ route('admin.doctors.edit',$doctor) }}">Edit</a>
  </td>
</tr>
@endforeach
</table>
@endsection