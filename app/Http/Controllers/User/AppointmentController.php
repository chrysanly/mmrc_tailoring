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
                $query->select(['date','time', 'status', 'user_id']);
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

        if ($request->time === null) {
            return response()->json([
                'message' => 'Please select time for your appointment.',
            ], 422);
        }

        [$open, $close] = explode(" - ", $formattedStoreHours[$dayOfWeek], 2); // Split by " - "

        [$start, $end] = explode('-', str_replace(' ', '', $request->time), 2); // Split by "-"
        $storeOpen = Carbon::parse($appointmentDate->toDateString() . ' ' . $open);
        $storeClose = Carbon::parse($appointmentDate->toDateString() . ' ' . $close);
        $requestedStart = Carbon::parse($appointmentDate->toDateString() . ' ' . $start);
        $requestedEnd = Carbon::parse($appointmentDate->toDateString() . ' ' . $end);

        if ($requestedStart < $storeOpen || $requestedEnd > $storeClose) {
            return response()->json([
                'message' => "Appointments on {$appointmentDate->toDateString()} ({$dayOfWeek}) are only available from " .
                    $storeOpen->format('g:i A') . " to " . $storeClose->format('g:i A') . ". " .
                    "Please select a valid time range.",
            ], 422);
        }

        Appointment::create([
            'date' => $request->date,
            'time' => $request->time,
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

    public function getAvailableTimeByDate(Request $request)
    {
        $data = $request->date;
        $appointmentDate = Carbon::parse($request->date);
        $appointments = Appointment::where('date', $data)
            ->get()->pluck('time')->toArray();

        // Start time and End time for the appointment slots
        $storeSchedule = $this->getStoreSchedule($appointmentDate->toDateString());

        $currentDay = Carbon::now()->format('l'); // 'l' gives the full name of the day, like "Monday", "Tuesday", etc.

        $currentDaySchedule = collect($storeSchedule)->first(function ($schedule) use ($currentDay) {
            return strpos($schedule, $currentDay) === 0; // Check if the schedule starts with the current day
        });

        $currentDayTimeRange = trim(explode(':', $currentDaySchedule, 2)[1]);
        [$open, $close] = explode('-', str_replace(' ', '', $currentDayTimeRange));

        $interval = (int) Settings::where('module', 'appointment_time_limit')->first()->limit;;
        $timeSlots = $this->generateTimeIntervals($open, $close, $interval);

        $data = [];
        foreach ($timeSlots as $slot) {
            $status = in_array($slot, $appointments) ? 'not available' : 'available';
            $data[] = [
                'time' => $slot,
                'status' => $status,
            ];
        }
        return response()->json($data);
    }

    private function generateTimeIntervals($start, $end, $interval)
    {
        $startTime = Carbon::createFromFormat('g:iA', $start);
        $endTime = Carbon::createFromFormat('g:iA', $end); // Do not add a day here

        $timeSlots = [];

        while ($startTime->lt($endTime)) { // Ensure it only generates until the end time
            $slotStart = $startTime->format('g:iA');
            $slotEnd = $startTime->copy()->addMinutes($interval)->format('g:iA');

            if ($startTime->copy()->addMinutes($interval)->gt($endTime)) {
                break; // Stop when adding the interval exceeds the end time
            }

            $timeSlots[] = "$slotStart - $slotEnd";
            $startTime->addMinutes($interval);
        }

        return $timeSlots;
    }
}
