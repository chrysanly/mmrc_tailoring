<?php

use App\Models\Appointment;

if (!function_exists('appointmentPendingCount')) {
    function appointmentPendingCount()
    {
        return Appointment::whereStatus('pending')->count();
    }
}