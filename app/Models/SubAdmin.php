<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'role',
        'email',
        'password',
    ];

    public function role()
    {
      return $this->belongsTo(Role::class,'role','id');
    }
}
