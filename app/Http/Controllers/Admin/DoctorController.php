<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->latest()->get();
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'specialty' => 'required|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request) {

            // 1️⃣ Create login account
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2️⃣ Assign role
            $user->assignRole('doctor');

            // 3️⃣ Create doctor profile
            Doctor::create([
                'user_id'   => $user->id,
                'name'      => $request->name,
                'email'     => $request->email, 
                'specialty' => $request->specialty,
                'phone'     => $request->phone,
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('doctors.index')
            ->with('success', 'Doctor added successfully.');
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

   public function update(Request $request, Doctor $doctor)
{
    $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email,' . $doctor->user_id,
        'specialty' => 'required|string|max:255',
        'phone'     => 'nullable|string|max:20',
        'is_active' => 'nullable|boolean',
    ]);

    \DB::transaction(function () use ($request, $doctor) {

        $doctor->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $doctor->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'specialty' => $request->specialty,
            'phone'     => $request->phone,
            'is_active' => $request->boolean('is_active'),
        ]);
    });

    return redirect()
        ->route('doctors.index')
        ->with('success', 'Doctor updated successfully.');
}


    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete(); // cascades doctor
        return back()->with('success', 'Doctor removed.');
    }
}
