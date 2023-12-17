<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Product $product)
    {
        return in_array('product_store',auth('seller')->user()->permissions->pluck('name')->toArray())
               ? Response::allow()
               : Response::deny('You are not allowed to store the product');
    }


    public function update(Product $product)
    {
        return in_array('product_update',auth('seller')->user()->permissions->pluck('name')->toArray())
               ? Response::allow()
               : Response::deny('You are not allowed to update the product!');
    }


    public function delete(Product $product)
    {
        return in_array('product_delete',auth('seller')->user()->permissions->pluck('name')->toArray())
               ? Response::allow()
               : Response::deny('You are not allowed to delete the product!');
    }
}
