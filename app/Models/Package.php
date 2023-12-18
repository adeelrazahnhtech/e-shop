<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'duration',
        'duration_unit',
        ];

    // public function admins(){
    //     return $this->belongsToMany(Admin::class,'admin_packages','admin_id','package_id');
    // }
}
