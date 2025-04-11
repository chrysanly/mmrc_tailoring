<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderPayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = [
        'file_url',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getFileUrlAttribute()
    {
        $directory = "payments/{$this->id}/"; // Directory path
        $files = Storage::disk('public')->files($directory); // Use public disk

        return !empty($files) ? Storage::url($files[0]) : null;
    }
    
}
