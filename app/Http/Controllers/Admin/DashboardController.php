<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\View\View;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\DashboardSalesReport;
use App\Models\OrderPayment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(public DashboardSalesReport $dashboardSalesReport){}
    public function index(): View
    { 
        
        
        $startYear = 2024;
        $currentYear = date('Y');

        $years = [];
        for ($year = $currentYear; $year >= $startYear; $year--) {
            $years[] = $year;
        }

        $appointments = Appointment::with('bottomMeasurement', 'topMeasurement')->latest()->get()->take(5);
        $orders = Order::latest()->get()->take(5);
        return view('admin.index', compact([
            'appointments',
            'orders',
            'years'
        ]));
    }

    public function appointmentOrderCounts()
    {
        // Define all possible statuses
        $allStatuses = ['pending', 'in-progress', 'done', 'completed'];

        // Get counts from the database
        $appointmentCounts = Appointment::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');
        $orderCounts = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Ensure all statuses are included, even if their count is 0
        $appointmentCount = collect($allStatuses)->mapWithKeys(function ($status) use ($appointmentCounts) {
            return [$status => $appointmentCounts->get($status, 0)];
        });
        $orderCount = collect($allStatuses)->mapWithKeys(function ($status) use ($orderCounts) {
            return [$status => $orderCounts->get($status, 0)];
        });

        return response()->json(compact('appointmentCount', 'orderCount'));
        // dd($counts);
    }

    public function salesReport(Request $request)
    {
        return $this->dashboardSalesReport->salesReport($request);
    }

    public function orderPaymentCounts(Request $request)
    {

        $allStatuses = ['Payment Settled', 'Down Payment'];

        $orderCounts = Order::select('payment_status', DB::raw('count(*) as total'))
            ->groupBy('payment_status')
            ->get()
            ->pluck('total', 'payment_status');


        $orderCount = collect($allStatuses)->mapWithKeys(function ($status) use ($orderCounts) {
            return [$status => $orderCounts->get($status, 0)];
        });
        

        return response()->json(compact( 'orderCount'));
    }
}
