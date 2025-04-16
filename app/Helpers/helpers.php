<?php

use App\Models\Appointment;
use App\Models\Order;

if (!function_exists('appointmentPendingCount')) {
    function appointmentPendingCount()
    {
        return Appointment::whereStatus('pending')->count();
    }
}
if (!function_exists('orderPendingCount')) {
    function orderPendingCount()
    {
        return Order::whereStatus('pending')->count();
    }
}