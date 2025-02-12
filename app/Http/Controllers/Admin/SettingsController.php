<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentOptions;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function viewAppointmentLimit(): View
    {
        return view('admin.settings.appointment_limit', [
            'limit' => Settings::first()->appointment_limit ?? 0,
        ]);
    }
  
    public function storeAppointmentLimit(Request $request)
    {
        $this->validate($request, [
            'limit' => 'required|string',
        ]);

        $settings = Settings::first();
        $settings->appointment_limit = $request->limit;
        $settings->save();

        return redirect()->back()->with('success', 'Appointment Limit Successfully Updated.');
        
    }
    
    public function editPaymentOption(PaymentOptions $paymentOptions)
    {
        return response()->json($paymentOptions);
    }
    public function updatePaymentOption(Request $request, PaymentOptions $paymentOptions)
    {
        $this->storeUpdatePaymentOption($request, $paymentOptions);
        return redirect()->back()->with('success', 'Payment Options Successfully Updated.');
    }
    
    public function destroyPaymentOption(Request $request, PaymentOptions $paymentOptions)
    {
        $paymentOptions->delete();

        return redirect()->back()->with('success', 'Payment Option Deleted Successfulyy.');
    }
}
