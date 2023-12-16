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
    public function viewAny(Seller $seller): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Seller $seller): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Seller $seller): bool
    {
    }

    public function store(Seller $seller): bool
    {
         
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Seller $seller): bool
    {
        return in_array('seller_update',auth('seller')->user()->permissions->pluck('name')->toArray())
        ? Response::allow()
        : Response::deny('You are not allowed to update the seller');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Seller $seller): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Seller $seller): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Seller $seller): bool
    {
        //
    }
}
