<?php

namespace App\Http\Controllers\User;

use App\Models\Polo;
use App\Models\Vest;
use App\Models\Order;
use App\Models\Pants;
use App\Models\Short;
use App\Models\Skirt;
use App\Models\Blazer;
use App\Models\Blouse;
use Illuminate\Support\Str;
use App\Models\OrderInvoice;
use App\Models\OrderPayment;
use App\Models\UniformPrice;
use Illuminate\Http\Request;
use App\Models\PaymentOptions;
use App\Models\UniformPriceItem;
use App\Http\Traits\PaymentTrait;
use App\Http\Traits\UniformTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\OrderPaymentRequest;
use App\Http\Requests\OrderReadyMadeRequest;
use App\Models\Settings;

class OrderController extends Controller
{
    use UniformTrait;
    use PaymentTrait;
    public function index(Request $request)
    {
        if ($request->order_type === 'customized') {
            return view('user.order.customized', [
                'uniformPrices' => UniformPrice::with('items')->get(),
            ]);
        }

        return view('user.order.ready_made',[
            'uniformPrices' => UniformPrice::with('items')->get(),
        ]);
    }
    public function orders()
    {
        return view('user.order.my-orders.index', [
            'orders' => auth()->user()->orders()->latest('created_at')->paginate(10),
        ]);
    }

    public function store(OrderRequest $request)
    {
        if ($request->form_type !== 'true') {
            DB::beginTransaction();
            try {
                $order = auth()->user()->orders()->create([
                    'order_type' => 'Customized',
                    'school' => $request->school,
                    'top' => $request->top,
                    'bottom' => $request->bottom,
                    'set' => $request->set,
                ]);

                $this->storeUniform($request, $order);

                $payment = $this->computeTotal($request);
                $payment['order_id'] = $order->id;
                $payment['total_payment'] = 0;
                $orderInvoice = OrderInvoice::create($payment);

                $order->additionalItems()->create([
                    'threads' => $request->additional_threads,
                    'zipper' => $request->additional_zipper,
                    'school_seal' => $request->additional_school_seal,
                    'buttons' => $request->additional_buttons,
                    'hook_and_eye' => $request->additional_hook_eye,
                    'tela' => $request->additional_tela,
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } else {
            
            $order = auth()->user()->orders()->create([
                'order_type' => 'Customized',
                'school' => $request->file_school,
                'top' => $request->file_top,
                'bottom' => $request->file_bottom,
            ]);

            if ($request->hasFile('file')) {
                $directory = 'orders/' . $order->id; // Directory path

                foreach ($request->file('file') as $file) {
                    $filename = $file->getClientOriginalName(); // Keep original file name

                    // Store each file inside storage/app/orders/{id} folder
                    $file->storeAs($directory, $filename);
                }
            }

            $payment = $this->computeTotal($request);
            $payment['order_id'] = $order->id;
            $orderInvoice = OrderInvoice::create($payment);

            $order->additionalItems()->create([
                'threads' => $request->additional_threads,
                'zipper' => $request->additional_zipper,
                'school_seal' => $request->additional_school_seal,
                'buttons' => $request->additional_buttons,
                'hook_and_eye' => $request->additional_hook_eye,
                'tela' => $request->additional_tela,
            ]);
        }

        return redirect()->route('user.order.payment', [
            'form_type' => $request->form_type,
            'order' => $order,
            'orderInvoice' => $orderInvoice,
        ]);
    }

    public function storeReadyMade(OrderReadyMadeRequest $request)
    {
        if ($request->form_type !== 'true') {
            DB::beginTransaction();
            try {
                $order = auth()->user()->orders()->create([
                    'order_type' => 'Ready Made',
                    'school' => $request->school,
                    'top' => $request->top,
                    'bottom' => $request->bottom,
                    'set' => $request->set,
                    'quantity' => $request->quantity,
                    'size' => $request->size,
                ]);

                $payment = $this->computeTotal($request);
                $payment['order_id'] = $order->id;
                $payment['total_payment'] = 0;
                $orderInvoice = OrderInvoice::create($payment);

                $order->additionalItems()->create([
                    'threads' => $request->additional_threads,
                    'zipper' => $request->additional_zipper,
                    'school_seal' => $request->additional_school_seal,
                    'buttons' => $request->additional_buttons,
                    'hook_and_eye' => $request->additional_hook_eye,
                    'tela' => $request->additional_tela,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } else {

            $order = auth()->user()->orders()->create([
                'order_type' => 'Ready Made',
                'school' => $request->file_school,
                'top' => $request->file_top,
                'bottom' => $request->file_bottom,
                'size' => $request->file_size,
                'quantity' => $request->file_quantity,
            ]);

            if ($request->hasFile('file')) {
                $directory = 'orders/' . $order->id; // Directory path

                foreach ($request->file('file') as $file) {
                    $filename = $file->getClientOriginalName(); // Keep original file name

                    // Store each file inside storage/app/orders/{id} folder
                    $file->storeAs($directory, $filename);
                }
            }

            $payment = $this->computeTotal($request);
            $payment['order_id'] = $order->id;
            $payment['total_payment'] = 0;
            $orderInvoice = OrderInvoice::create($payment);

            $order->additionalItems()->create([
                'threads' => $request->additional_threads,
                'zipper' => $request->additional_zipper,
                'school_seal' => $request->additional_school_seal,
                'buttons' => $request->additional_buttons,
                'hook_and_eye' => $request->additional_hook_eye,
                'tela' => $request->additional_tela,
            ]);
        }

        return redirect()->route('user.order.payment', [
            'form_type' => $request->form_type,
            'order' => $order,
            'orderInvoice' => $orderInvoice,
        ]);
    }

    public function payment(string $form_type, Order $order)
    {
        $order->load(relations: 'invoice');
        return view('user.order.payment', [
            'order' => $order,
            'formType' => $form_type,
            'paymentOptions' => PaymentOptions::all(),
            'downpayment' => Settings::downpaymentPercentage(),
        ]);
    }

    public function storePayment(OrderPaymentRequest $request, Order $order)
    {
        
        $validatedData = $request->safe()->except('file'); // Remove file safely
        $validatedData['order_id'] = $order->id;
        $file = $request->file('file'); // Get the file
        $downpayment = Settings::downpaymentPercentage();
        $amount = 0;
        if ($request->type === 'downpayment') {
            $amount = $order->invoice->total * ($downpayment / 100);
        }

        if ($request->type === 'balance') {
            $amount = $order->invoice->total - $order->invoice->total_payment;
        }
        
        if ($request->type === 'fullpayment') {
            $amount = $order->invoice->total;
        }

        if ($order->status === 'in-progress') {
            alert()->error('Payment Failed', 'Your order is still in progress. Please wait for an email from the admin when it’s ready so you can settle the remaining balance.');
            return redirect()->back()->withInput();
        }
       
        $validatedData['amount'] = $amount;
        $payment = OrderPayment::create($validatedData);

        if ($file) {
            $directory = 'payments/' . $payment->id; // Directory path
            $filename = $file->getClientOriginalName(); // Keep original file name

            // Store the file inside the storage/app/payments/{id} folder
            $file->storeAs($directory, $filename);
        }
        alert()->success('Payment Sent Successfully', 'Your payment has been sent. Please wait for the admin to verify it. You can check your order status on the "My Orders" page.');

        $successUrl = URL::temporarySignedRoute('user.order.success', now()->addMinutes(30));
        return redirect($successUrl);
    }

    public function success(Request $request)
    {
        if (!request()->hasValidSignature()) {
            toast('Link Expired', 'error');
            return redirect()->back();
        }

        return view('user.order.success');
    }

    public function viewOrder(Order $order)
    {
        return response()->json(['data' => $order->load('topMeasurement.measurable', 'bottomMeasurement.measurable', 'invoice', 'payments', 'additionalItems')]);
    }

    public function markAsComplete(Order $order)
    {
        $order->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        toast('Order marked as completed, Thank you!', 'success');

        return redirect()->back();
    }
}
