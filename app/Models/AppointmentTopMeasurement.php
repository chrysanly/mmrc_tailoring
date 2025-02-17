<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTopMeasurement extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function polo()
    {
        return $this->hasOne(Polo::class);
    }
    public function blouse()
    {
        return $this->hasOne(Blouse::class);
    }
    public function vest()
    {
        return $this->hasOne(Vest::class);
    }
    public function blazer()
    {
        return $this->hasOne(Blazer::class);
    }

    public function measurable()
    {
        return $this->morphTo(null, 'top_measure_type', 'top_measure_id');
    }
}
