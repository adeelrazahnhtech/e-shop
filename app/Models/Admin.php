<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
      'role',
      'first_name',
      'last_name',
      'email',
      'email_verified_at',
      'token',
      'password',
    ];

    public function roleType()
    {
      return $this->belongsTo(Role::class,'role','id');
    }
}
