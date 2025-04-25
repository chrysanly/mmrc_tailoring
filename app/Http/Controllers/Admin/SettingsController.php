<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentOptions;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.settings', [
            'appointmentMaxLimit' => $this->settingValues('appointment_max_limit'),
            'appointmentTimeLimit' => $this->settingValues('appointment_time_limit'),
            'downpaymentPercentage' => $this->settingValues('downpayment_percentage'),
        ]);
    }

    public function storeAppointmentLimit(Request $request)
    {
        $this->validate($request, [
            'limit' => 'required|string',
        ]);

        $settings = Settings::where('module', 'appointment_max_limit')->first();
        $settings->limit = $request->limit;
        $settings->save();

        toast('Appointment Max Limit Successfully Updated.', 'success');

        return redirect()->back();
    }

    public function storeDownPaymentPercentage(Request $request)
    {
        $request->validate([
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $settings = Settings::where('module', 'downpayment_percentage')->first();
        $settings->limit = $request->percentage;
        $settings->save();

        toast('Percentage saved successfully.', 'success');
        return redirect()->back();
    }

    public function storeAppointmentTimeLimit(Request $request)
    {
        $this->validate($request, [
            'limit' => 'required|string',
        ]);

        $settings = Settings::where('module', 'appointment_time_limit')->first();
        $settings->limit = $request->limit;
        $settings->save();

        toast('Appointments Time Limit Successfully Updated.', 'success');

        return redirect()->back();
    }

    private function settingValues(string $module): int
    {
        return (int) Settings::where('module', $module)->first()->limit;
    }
}
