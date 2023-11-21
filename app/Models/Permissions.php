<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;
    protected $fillable=['name','display_name','parent_id','key_code'];

    public function permisstionsChildren()
    {
        return $this->hasMany(Permissions::class,'parent_id');
    }
}
