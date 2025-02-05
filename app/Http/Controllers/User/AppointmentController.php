<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('user.appointment.index');
    }

    public function getAllAppointments()
    {
        $appointments = Appointment::selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        return response()->json([
            'appointments' => $appointments
        ]);
    }
    public function store(Request $request)
    {
        $checkExistingAppointment = Appointment::where('date', $request->date)
        ->where('user_id', auth()->id())
        ->first();

        if ($checkExistingAppointment) {
            return redirect()->back()->with('error', 'You already have an appointment on this date: ' . $request->date);
        }

        Appointment::create([
            'date' => $request->date,
            'user_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Appointment created successfully, please wait for the approval from the admin.');

    }

   
}
