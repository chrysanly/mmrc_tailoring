<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class PercentageController extends Controller
{
    public function index()
    {
        $downpayment = Settings::first()->downpayment;
        return view('admin.settings.percentage', compact('downpayment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        Settings::updateOrCreate(['id' => 1], ['downpayment' => $request->percentage]);
        toast('Percentage saved successfully.', 'success');
        return redirect()->back();
    }
}
