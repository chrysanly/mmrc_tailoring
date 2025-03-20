<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Settings;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\StoreScheduleTrait;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AppointmentResource;

class AppointmentController extends Controller
{
    use StoreScheduleTrait;
    public function index()
    {
        return view('user.appointment.index', [
            'limit' => Settings::first()->appointment_limit ?? 0,
        ]);
    }

    public function viewMyAppointment(Request $request)
    {
        $limit = 5;
        $appointments = auth()->user()->appointments()
            ->with('topMeasurement.measurable', 'bottomMeasurement.measurable')
            ->latest()
            ->paginate(perPage: $limit);
        return view('user.appointment.my-appointment', [
            'appointments' => $appointments,
            'limit' => $limit,
        ]);
    }

    public function getAllAppointments()
    {
        $appointments = Appointment::selectRaw('date, MAX(id) as id, MAX(user_id) as user_id')
            ->groupBy('date')
            ->with(['appointments' => function ($query) {
                $query->select(['date', 'time_from', 'time_to', 'status','user_id']);
            }])
            ->get();

        return response()->json([
            'appointments' => AppointmentResource::collection($appointments),
        ]);
    }
    public function store(Request $request)
    {
        $appointmentDate = Carbon::parse($request->date);

        $dayOfWeek = $appointmentDate->format('l'); // Get full weekday name (e.g., Monday)

        $storeSchedule = $this->getStoreSchedule($appointmentDate->toDateString());

        $formattedStoreHours = [];

        foreach ($storeSchedule as $entry) {
            [$day, $hours] = explode(":", $entry, 2); // Split by ":"
            $formattedStoreHours[trim($day)] = trim($hours);
        }

        if ($formattedStoreHours[$dayOfWeek] === 'Closed') {
            return response()->json([
                'message' => "The store is closed on {$appointmentDate->toDateString()} ({$dayOfWeek}). Please select a different day.",
            ], 422);
        }

        $checkExistingAppointment = Appointment::where('date', $request->date)
            ->where('user_id', auth()->id())
            ->first();

        if ($checkExistingAppointment) {
            return response()->json([
                'message' => 'You already have an appointment on this date: ' . $request->date,
            ], 422);
        }

        if ($request->time_from === null || $request->time_to === null) {
            return response()->json([
                'message' => 'Please select both start and end times for your appointment.',
            ], 422);
        }

        [$open, $close] = explode(" - ", $formattedStoreHours[$dayOfWeek], 2); // Split by " - "

        $storeOpen = Carbon::parse($appointmentDate->toDateString() . ' '. $open);
        $storeClose = Carbon::parse($appointmentDate->toDateString() . ' ' . $close);
        $requestedStart = Carbon::parse($appointmentDate->toDateString() . ' ' . $request->time_from);
        $requestedEnd = Carbon::parse($appointmentDate->toDateString() . ' ' . $request->time_to);

        if ($requestedStart < $storeOpen || $requestedEnd > $storeClose) {
            return response()->json([
                'message' => "Appointments on {$appointmentDate->toDateString()} ({$dayOfWeek}) are only available from " .
                    $storeOpen->format('g:i A') . " to " . $storeClose->format('g:i A') . ". " .
                    "Please select a valid time range.",
            ], 422);
        }

        Appointment::create([
            'date' => $request->date,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Appointment created successfully, please wait for the approval from the admin.',
        ], 200);
    }

    public function cancelAppointment(Appointment $appointment, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($appointment->status === 'approved') {
            return response()->json([
                'message' => 'You cannot cancel an approved appointment.',
            ], 422);
        }

        $appointment->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => auth()->id(),
            'cancelled_reason' => $request->reason,
        ]);

        return response()->json([
            'message' => 'Appointment cancelled successfully.',
        ], 200);
    }   
}
