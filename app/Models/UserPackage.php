<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'package_id',
        'payment_id',
    ];
    protected $table = 'user_packages';
}
