<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\AvailableTimeTrait;
use Carbon\Carbon;
use App\Models\Polo;
use App\Models\Vest;
use App\Models\Pants;
use App\Models\Short;
use App\Models\Skirt;
use App\Models\Blazer;
use App\Models\Blouse;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\UniformPriceItem;
use App\Http\Traits\UniformTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserAppointmentStatus;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\AppointmentRequest;
use App\Http\Traits\PaymentTrait;
use App\Http\Traits\StoreScheduleTrait;
use App\Mail\SendUserRescheduleAppointment;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    use UniformTrait;
    use StoreScheduleTrait;
    use AvailableTimeTrait;

    public function index()
    {
        $appointments = Appointment::with('topMeasurement.measurable', 'bottomMeasurement.measurable')
            ->when(request('status') !== 'all', function ($query) {
                $query->whereStatus(request('status'));
            })->latest('updated_at')->paginate(10)->withQueryString();
        return view('admin.appointment.index', [
            'appointments' => $appointments,
        ]);
    }

    public function getMeasurement(Request $request, Appointment $appointment)
    {
        return view('admin.appointment.get-measurement', compact('appointment'));
    }
    public function viewMeasurement(Request $request, Appointment $appointment)
    {
        $appointment->load('topMeasurement.measurable', 'bottomMeasurement.measurable', 'user');
        return view('admin.appointment.view-measurement', compact('appointment'));
    }
    public function storeMeasurement(AppointmentRequest $request, Appointment $appointment)
    {
        DB::beginTransaction();
        try {
            $appointment->update([
                'top' => $request->top,
                'school' => $request->school,
                'bottom' => $request->bottom,
                'set' => $request->set,
            ]);

            $this->storeUniform($request, $appointment);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        toast('The uniform measurement has been saved successfully', 'success');
        return redirect()->route('admin.appointment.index', ['status' => 'in-progress']);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $appointment->update([
            'status' => $request->status
        ]);

        if ($appointment->status === 'completed') {
            $appointment->update([
                'completed_at' => now(),
            ]);
        }

        if ($appointment->status !== 'in-progress') {
            Mail::to($appointment->user->email)->send(new SendUserAppointmentStatus($appointment));
        }
        toast('Appointment moved to ' . ucwords(str_replace('-', ' ', $request->status)), 'success');

        return redirect()->route('admin.appointment.index', [
            'status' => request('status'),
        ]);
    }

    public function reschedule(Appointment $appointment, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date:Y-m-d',
            'time' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

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



        $appointment->update([
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending',
        ]);


        Mail::to($appointment->user->email)->send(new SendUserRescheduleAppointment($appointment));


        return response()->json([
            'message' => 'Appointment rescheduled successfully.',
        ]);
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
        return response()->json($this->execute($request));
    }

    public function getAppointmentMeasurement(Appointment $appointment)
    {
        $appointment->load(['topMeasurement.measurable', 'bottomMeasurement.measurable']);
        return response()->json($appointment);
    }
}
