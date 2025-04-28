<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PaymentOptions;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.settings', [
            'appointmentMaxLimit' => Settings::appointmentMaxLimit(),
            'appointmentTimeLimit' => Settings::appointmentTimeLimit(),
            'downpaymentPercentage' => Settings::downpaymentPercentage(),
        ]);
    }

    public function storeAppointmentLimit(Request $request)
    {
        return $this->logic('whereAppointmentMaxLimit', $request, 'Appointment Max Limit');
    }

    public function storeDownPaymentPercentage(Request $request)
    {
        return $this->logic('whereDownpaymentPercentage', $request, 'Percentage');
    }

    public function storeAppointmentTimeLimit(Request $request)
    {
        return $this->logic('whereAppointmentTimeLimit', $request, 'Appointments Time Limit');
    }

    private function logic(string $where, Request $request, string $message): RedirectResponse
    {

        $this->validate($request, [
            'limit' => 'required|numeric',
        ]);

        if ($request->limit > 100) {
            toast($message . ' field must not be greater than 100.', 'error');
            return redirect()->back();
        }

        $settings = Settings::$where();
        $settings->limit = $request->limit;
        $settings->save();

        toast($message . ' Successfully Updated.', 'success');

        return redirect()->back();
    }
}
