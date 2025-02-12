<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserAppointmentStatus;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointment.index', [
            'appointments' => Appointment::latest()->paginate(10)
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Appointment already approved or rejected.');
        }

        $appointment->update([
            'status' => $request->status
        ]);

        // Enable this line to send email to user
        Mail::to($appointment->user->email)->send(new SendUserAppointmentStatus($request->status, $appointment->date));

        return redirect()->back()->with('success', 'Appointment status updated successfully.');
    }
}
