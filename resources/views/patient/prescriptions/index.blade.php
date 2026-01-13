@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6">
    <h2 class="font-semibold text-xl mb-4">My Prescriptions</h2>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Date</th>
                <th class="p-2">Doctor</th>
                <th class="p-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prescriptions as $p)
                <tr>
                    <td class="p-2">{{ $p->created_at->format('Y-m-d') }}</td>
                    <td class="p-2">{{ $p->consultation->doctor->name }}</td>
                    <td class="p-2">
                        <a href="{{ route('patient.prescriptions.show',$p) }}"
                           class="text-indigo-600">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
