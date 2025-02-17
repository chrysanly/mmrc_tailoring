<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottomMeasurement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function short()
    {
        return $this->hasOne(Polo::class);
    }
    public function pant()
    {
        return $this->hasOne(Blouse::class);
    }
    public function skirt()
    {
        return $this->hasOne(Vest::class);
    }
    public function measurable()
    {
        return $this->morphTo(null, 'bottom_measure_type', 'bottom_measure_id');
    }
}
