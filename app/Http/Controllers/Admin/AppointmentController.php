<?php

namespace App\Http\Controllers\Admin;

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

class AppointmentController extends Controller
{
    use UniformTrait;
    public function index()
    {
        $appointments = Appointment::with('topMeasurement.measurable', 'bottomMeasurement.measurable')
            ->when(request('status') !== 'all', function ($query) {
                $query->whereStatus(request('status'));
            })->latest('updated_at')->paginate(10);
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

        if ($appointment->status === 'done') {
            Mail::to($appointment->user->email)->send(new SendUserAppointmentStatus($appointment));
        }

        toast('Appointment moved to ' . ucwords(str_replace('-', ' ', $request->status)), 'success');

        return redirect()->route('admin.appointment.index', [
            'status' => request('status'),
        ]);
    }
}
