<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Show payment page (dummy gateway)
     */
    public function pay(Appointment $appointment)
    {
        $user = Auth::user();

        // Patient only
        abort_unless($user->hasRole('patient'), 403);

        // Own appointment only
        abort_unless($appointment->patient->user_id === $user->id, 403);

        // Must be pending payment
        abort_unless($appointment->status === 'pending_payment', 403);

        // Fetch payment (must exist)
        $payment = Payment::where('appointment_id', $appointment->id)->firstOrFail();

        return view('payments.pay', compact('appointment', 'payment'));
    }

    /**
     * Dummy payment success
     */
    public function success(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        $appointment = Appointment::with('doctor')->findOrFail($request->appointment_id);

        // Security check
        abort_unless(
            $appointment->patient->user_id === auth()->id(),
            403
        );

        $payment = Payment::where('appointment_id', $appointment->id)->firstOrFail();

        // Update payment
        $payment->update([
            'status'         => 'paid',
            'transaction_id' => 'DUMMY-' . strtoupper(uniqid()),
        ]);

        // Update appointment
        $appointment->update([
            'status' => 'booked',
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Payment successful. Appointment booked.');
    }
}
