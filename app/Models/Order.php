<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = [
        'file_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(OrderInvoice::class);
    }
    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function topMeasurement()
    {
        return $this->hasOne(TopMeasurement::class);
    }
    public function bottomMeasurement()
    {
        return $this->hasOne(BottomMeasurement::class);
    }
    public function additionalItems()
    {
        return $this->hasOne(AdditionalItems::class);
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
    public function getOrderTypeAttribute($value)
    {
        return $value ? ucwords($value) : 'N/A';
    }
    public function getPaymentStatusAttribute($value)
    {
        return ucwords(str_replace('-', ' ', $value));
    }

    public function getFileUrlAttribute()
    {
        $directory = "orders/{$this->id}/"; // Directory path
        $files = Storage::disk('public')->files($directory); // Get all files in the directory

        return !empty($files)
            ? array_map(fn($file) => Storage::url($file), $files)
            : [];
    }
}
