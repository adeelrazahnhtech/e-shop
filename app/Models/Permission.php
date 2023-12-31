<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
       'name',
    ];

    public function seller()
    {
        return $this->hasOne(SellerPermission::class, 'permission_id', 'id');
    }
}
