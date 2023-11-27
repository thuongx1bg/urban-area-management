<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable = [
        'qr_id',
    ];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class,'qr_id');
    }
}
