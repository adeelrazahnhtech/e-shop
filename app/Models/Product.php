<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'title',
        'description',
        'price',
        'track_qty',
        'status',
        'admin',
        'sub_admin',
        'seller',
    ];

    public function categoryWise()
    {
        return $this->belongsTo(Category::class,'category','id');
    }

    public function adminType()
    {
        return $this->belongsTo(Admin::class,'admin','id');
    }


    public function subAdminType()
    {
        return $this->belongsTo(SubAdmin::class,'sub_admin','id');
    }


    public function sellerType()
    {
        return $this->belongsTo(Seller::class,'seller','id');
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

    
}
