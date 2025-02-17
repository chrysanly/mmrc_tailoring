<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Settings;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentLimitController extends Controller
{
    public function view(): View
    {
        return view('admin.settings.appointment_limit', [
            'limit' => Settings::first()->appointment_limit ?? 0,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'limit' => 'required|string',
        ]);

        $settings = Settings::first();
        $settings->appointment_limit = $request->limit;
        $settings->save();

        return redirect()->back()->with('success', 'Appointment Limit Successfully Updated.');
    }
}
