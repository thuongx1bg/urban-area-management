<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username','building_id',
        'phone',
        'status',
        'cmt',
        'public_key', 'private_key',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role','user_id','role_id');
    }

    public function checkPermissionAccess($checkPermission)
    {
        $roles = Auth::user()->roles;
        foreach ($roles as $role) {
            $permission = $role->permissions;
            if($permission->contains('key_code',$checkPermission)){
                return true;
            }
        }
        return false;
        // b1 laasy cac quyen user dang login

        // b2 so sanh gia tri dua vao router hien tai cos ton tai trong cac quyfn lay ko
    }
}
