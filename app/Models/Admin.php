<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
    ];

    public function role()
    {
      return $this->belongsTo(Role::class,'role','id');
    }
}
