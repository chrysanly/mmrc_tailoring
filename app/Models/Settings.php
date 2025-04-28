<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeDownpaymentPercentage($query)
    {
        return $this->scopeWhereDownpaymentPercentage($query)->limit;
    }
    public function scopeAppointmentTimeLimit($query)
    {
        return $this->scopeWhereAppointmentTimeLimit($query)->limit;
    }
    public function scopeAppointmentMaxLimit($query)
    {
        return $this->scopeWhereAppointmentMaxLimit($query)->limit;
    }
    public function scopeWhereDownpaymentPercentage($query)
    {
        return $query->where('module', 'downpayment_percentage')->first();
    }
    public function scopeWhereAppointmentTimeLimit($query)
    {
        return $query->where('module', 'appointment_time_limit')->first();
    }
    public function scopeWhereAppointmentMaxLimit($query)
    {
        return $query->where('module', 'appointment_max_limit')->first();
    }
}
