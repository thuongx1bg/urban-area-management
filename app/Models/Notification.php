<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $keyType = 'string';
    public $incrementing = false;

    public static function notificationForAdmin()
    {
        $userResident = User::whereHas('roles',function ($query){
            $query->where('role_id',2);
        })->get()->pluck('id');
        return static::whereIn('notifiable_id',$userResident)->get();
    }
    public static function notificationForResident()
    {
        $userResident = User::whereHas('roles',function ($query){
            $query->where('role_id',2);
        })->get()->pluck('id');
        return static::whereNotIn('notifiable_id',$userResident)->get();
    }
}
