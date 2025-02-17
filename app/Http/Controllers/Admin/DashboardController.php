<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $inProgressAppointments = Appointment::where('status', 'in-progress')->count();
        $doneAppointments = Appointment::where('status', 'done')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $inProgressOrders = Order::where('status', 'in-progress')->count();
        $doneOrders = Order::where('status', 'done')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        $appointments = Appointment::with('bottomMeasurement', 'topMeasurement')->latest()->get()->take(5);
        $orders = Order::latest()->get()->take(5);
        return view('admin.index', compact([
            'pendingAppointments',
            'inProgressAppointments',
            'doneAppointments',
            'completedAppointments',
            'pendingOrders',
            'completedAppointments',
            'inProgressOrders',
            'doneOrders',
            'completedOrders',
            'appointments',
            'orders',
        ]));
    }
}
