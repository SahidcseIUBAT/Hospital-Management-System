<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorLeave;
use Illuminate\Http\Request;

class DoctorLeaveController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        $leaves = $doctor->leaves()->orderBy('date')->get();

        return view('doctors.leaves', compact('doctor','leaves'));
    }

    public function store(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        $data = $request->validate([
            'date'   => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string|max:255',
        ]);

        DoctorLeave::create([
            'doctor_id' => $doctor->id,
            'date'      => $data['date'],
            'reason'    => $data['reason'],
        ]);

        return back()->with('success','Leave added.');
    }


    
    

    public function destroy(DoctorLeave $leave)
    {
        abort_unless($leave->doctor->user_id === auth()->id(), 403);

        $leave->delete();

        return back()->with('success','Leave removed.');
    }
}
