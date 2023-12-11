<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function admin()
    {
      return $this->belongsTo(Admin::class);
    }

    public function subadmin()
    {
      return $this->belongsTo(SubAdmin::class);
    }

    public function seller()
    {
      return $this->belongsTo(Seller::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    
}
