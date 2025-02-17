<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentOptions;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.payment_option');
    }

    public function getAllPaymentOption(): JsonResponse
    {
        return response()->json([
            'data' => PaymentOptions::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $this->storeUpdatePaymentOption($request, new PaymentOptions());
    }
    public function edit(PaymentOptions $paymentOption)
    {
        return response()->json(data: [
            'data' => $paymentOption,
        ]);
    }

    public function update(Request $request, PaymentOptions $paymentOption)
    {
        $this->storeUpdatePaymentOption($request, $paymentOption);
    }
    public function destroy(PaymentOptions $paymentOptions): bool|null
    {
        return $paymentOptions->delete();
    }

    private function storeUpdatePaymentOption(Request $request, PaymentOptions $paymentOptions): void
    {
        $request->validate([
            'name' => 'required|unique:payment_options,name,' . ($paymentOptions->id ?? 'NULL'),
            'account_number' => 'required|numeric',
            'account_name' => 'required',
        ]);

        $paymentOptions->name = $request->name;
        $paymentOptions->account_number = $request->account_number;
        $paymentOptions->account_name = $request->account_name;
        $paymentOptions->save();
    }
}
