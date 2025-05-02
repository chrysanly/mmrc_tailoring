<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\OrderInvoice;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use App\Mail\SendUserOrderStatus;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserOrderStatusDone;
use App\Mail\SendUserOrderStatusCompleted;
use App\Mail\SendUserOrderStatusInProgress;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::with('topMeasurement', 'topMeasurement.measurable')
            ->when(request('status') !== 'all', function ($query) {
                $query->whereStatus(request('status'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.order.index', [
            'orders' => $order,
        ]);
    }

    public function viewOrder(Order $order)
    {
        return response()->json(['data' => $order->load('topMeasurement.measurable', 'bottomMeasurement.measurable', 'invoice', 'payments', 'additionalItems')]);
    }

    public function paymentVerified(OrderPayment $orderPayment)
    {
        $invoice = $orderPayment->order->invoice;
        $totalPayment = (float) $invoice->total_payment + (float) $orderPayment->amount;

        if (Str::lower($orderPayment->order->payment_status) === 'down payment') {
            if ((int) $totalPayment < (int) $invoice->total) {
                return response()->json(['message' => 'The total payment is less than the required amount.']);
            }

            if ((int) $totalPayment > (int) $invoice->total) {
                return response()->json(['message' => 'The total payment exceeds the required amount.']);
            }
        }


        $orderPayment->update([
            'is_verified' => true,
        ]);

        if ($orderPayment->type === 'fullpayment' || $orderPayment->type === 'balance') {
            $orderPayment->order()->update([
                'payment_status' => 'payment-settled',
            ]);
        }

        if ($orderPayment->type === 'downpayment') {
            $orderPayment->order()->update([
                'payment_status' => 'down-payment',
            ]);
        }

       
        $orderPayment->order->invoice()->update([
            'total_payment' => (float) $totalPayment,
            'is_paid' => Str::lower($orderPayment->order->payment_status) === 'payment settled' ? true : false,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        


        if ($request->status === 'in-progress' || $request->status === 'done' || $request->status === 'pick-up') {
            toast('Order updated to ' . ucwords(str_replace('-', ' ', $request->status)) . ' and the user has been notified via email.', 'success');
            Mail::to($order->user->email)->send(new SendUserOrderStatus($order, $request->status));
            $order->update([
                'status' => $request->status,
            ]);
        }
        

        if ($request->status === 'completed') {
            toast('The user has been successfully reminded via email.', 'success');
            Mail::to($order->user->email)->send(new SendUserOrderStatusCompleted($order));
            return redirect()->back();
        }

        return redirect()->route('admin.order.index', [
            'status' => request('status'),
        ]);
    }

    public function discount(Request $request, OrderInvoice $orderInvoice): JsonResponse
    {
        $discount = (float) $request->discount;

        if ($discount < 0 || $discount > 100) {
            return response()->json([
                'error' => 'Invalid discount value. Please enter a percentage between 0 and 100.'
            ], 422);
        }

        $discountAmount = ($orderInvoice->total * $discount) / 100;

        $newTotal = $orderInvoice->total - $discountAmount;

        $orderInvoice->update([
            'discount' => $discount,
            'total' => $newTotal,
        ]);

        return response()->json([
            'success' => 'Success'
        ]);
    }

    public function settleBalance(Request $request, Order $order)
    {
        $orderPayment = $order->payments()->create([
            'type' => 'balance',
            'order_id' => $order->id,
            'contact_number' => $request->contact_number,
            'referrence_number' => $request->ref_number,
            'account_name' => $request->account_name,
            'amount' => (float) $order->invoice->total - (float) $order->invoice->total_payment,
            'is_verified' => 1,
        ]);

        $invoice = $orderPayment->order->invoice;
        $totalPayment = (float) $invoice->total_payment + (float) $orderPayment->amount;

        $orderPayment->order()->update([
            'payment_status' => 'payment-settled',
            'status' => 'pick-up',
        ]);

        $orderPayment->order->invoice()->update([
            'total_payment' => (float) $totalPayment,
            'is_paid' => Str::lower($orderPayment->order->payment_status) === 'payment settled' ? true : false,
        ]);

        $route = route('admin.order.index', ['status' => 'pick-up']);
        
        return response()->json([
            'route' => $route,
        ]);
    }
}
