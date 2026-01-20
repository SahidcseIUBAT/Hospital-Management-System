<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function pay(Appointment $appointment)
{
    // Authorization check
    abort_unless($appointment->patient->user_id === Auth::id(), 403);
    
    // Load doctor relationship
    $appointment->load('doctor');
    
    // Check if payment is still needed
    if (!in_array($appointment->status, ['pending_payment'])) {
        return redirect()->route('patient.appointments')
            ->with('info', 'This appointment is already confirmed.');
    }
    
    if ($appointment->payment_status === 'paid') {
        return redirect()->route('patient.appointments')
            ->with('info', 'This appointment is already paid.');
    }
    
    return view('payments.pay', compact('appointment'));
}

    public function process(Request $request, Appointment $appointment)
    {
        // Authorization check
        abort_unless($appointment->patient->user_id === Auth::id(), 403);
        
        // Sandbox payment simulation
        $appointment->update([
            'status' => 'booked',
            'payment_status' => 'paid',
            'payment_method' => 'sslcommerz',
        ]);
        
        // Update payment record
        $appointment->payment()->update([
            'status' => 'paid',
            'transaction_id' => 'TXN-SIM-' . time(),
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Payment successful! Appointment confirmed.');
    }
}
