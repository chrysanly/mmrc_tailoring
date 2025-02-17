<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniformPriceItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function uniformPrice()
    {
        return $this->belongsTo(UniformPrice::class);
    }
}
