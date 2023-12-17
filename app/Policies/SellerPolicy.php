<?php

namespace App\Policies;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SellerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function __construct()
    {
        //
    }
    public function viewAny(Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Seller $seller)
    {
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(Seller $seller)
    {
        return in_array('seller_update',auth('seller')->user()->permissions->pluck('name')->toArray())
        ? Response::allow()
        : Response::deny('You are not allowed to update the seller');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Seller $seller)
    {
        return in_array('seller_delete',auth('seller')->user()->permissions->pluck('name')->toArray())
        ? Response::allow()
        : Response::deny('You are not allowed to delete the seller');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Seller $seller)
    {
        //
    }
}
