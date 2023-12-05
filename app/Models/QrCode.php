<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrCode extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'ds','user_id','name','note','si','own_id','phone','gender','date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function histories()
    {
        return $this->hasMany(History::class,'qr_id','id');
    }
}
