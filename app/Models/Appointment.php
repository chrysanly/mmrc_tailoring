<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = [
        'appointment_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'date', 'date');
    }

    public function topMeasurement()
    {
        return $this->hasOne(AppointmentTopMeasurement::class);
    }
    public function bottomMeasurement()
    {
        return $this->hasOne(AppointmentBottomMeasurement::class);
    }
    public function getSetAttribute($value)
    {
        return $value ? ucwords($value) : 'N/A';
    }
    public function getTopAttribute($value)
    {
        return $value ? ucwords($value) : 'N/A';
    }
    public function getBottomAttribute($value)
    {
        return $value ? ucwords($value) : 'N/A';
    }

    public function getAppointmentTimeAttribute()
    {
        return Carbon::parse($this->time_from)->format('g:i A') . ' - ' . Carbon::parse($this->time_to)->format('g:i A');
    }
}
