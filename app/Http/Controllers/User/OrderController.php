<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->order_type === 'customized') {
            return view('user.order.customized');
        }

        return view('user.order.ready_made');
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_type' => 'required|string',
            'file' => 'required_if:form_type,true|file',
            'school' => 'required_if:form_type,false',
            'top' => 'required_if:form_type,false',
            'bottom' => 'required_if:form_type,false',
            'set' => 'required_if:form_type,false',
        ]);

        if ($request->form_type !== 'true') {
            $order = auth()->user()->orders()->create([
            'order_type' => $request->order_type,
            'school' => $request->school,
            'top' => $request->top,
            'bottom' => $request->bottom,
            'set' => $request->set,
            ]);
        } else {
            $path = $request->file('file')->store('orders');
            $order = auth()->user()->orders()->create([
                'order_type' => $request->order_type,
                'path' => $path,
            ]);
        }
        return $this->payment($request->form_type, $order);
    }

    public function payment(string $form_type, Order $order)
    {
        return view('user.order.payment', [
            'order' => $order,
            'formType' => $form_type,
        ]);
    }
}
