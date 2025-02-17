<?php

namespace App\Http\Controllers\User;

use App\Models\Settings;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('user.appointment.index', [
            'limit' => Settings::first()->appointment_limit ?? 0,
        ]);
    }

    public function viewMyAppointment(Request $request)
    {
        $appointments = auth()->user()->appointments()
            ->with('topMeasurement.measurable', 'bottomMeasurement.measurable')
            ->latest()
            ->paginate(perPage: 5);
        return view('user.appointment.my-appointment', [
            'appointments' => $appointments,
        ]);
    }

    public function getAllAppointments()
    {
        $appointments = Appointment::selectRaw('date, MAX(id) as id, MAX(user_id) as user_id')
            ->groupBy('date')
            ->with(['appointments' => function ($query) {
                $query->select(['date', 'time_from', 'time_to', 'status']);
            }])
            ->get();

        return response()->json([
            'appointments' => AppointmentResource::collection($appointments),
        ]);
    }
    public function store(Request $request)
    {
        $checkExistingAppointment = Appointment::where('date', $request->date)
            ->where('user_id', auth()->id())
            ->first();

        if ($checkExistingAppointment) {
            toast( 'You already have an appointment on this date: ' . $request->date , 'warning');
            return redirect()->back();
        }

        if ($request->time_from === null || $request->time_to === null) {
            toast('Please select both start and end times for your appointment.', 'warning');

            return redirect()->back();
        }

        $overlappingAppointment = Appointment::where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('time_from', [$request->time_from, $request->time_to])
                    ->orWhereBetween('time_to', [$request->time_from, $request->time_to])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('time_from', '<=', $request->time_from)
                            ->where('time_to', '>=', $request->time_to);
                    });
            })
            ->first();

        if ($overlappingAppointment) {

            toast('The selected time range overlaps with an existing appointment.', 'warning');
            return redirect()->back();
        }

        Appointment::create([
            'date' => $request->date,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'user_id' => auth()->id()
        ]);

        toast('Appointment created successfully, please wait for the approval from the admin.', 'success');
        return redirect()->back();
    }
}
