<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Seller;
use App\Models\SubAdmin;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $users = User::with('roleType')->get();
        return view('admin.permission.user', compact('users'));
    }

    public function approved($userId)
    {
        $user = User::findOrFail($userId);
       if($user){
          $user->update(['email_verified_at' => 1, 'token' => null]);
          flash()->addSuccess('Successfully user has been approved');
          return redirect()->route('admin.user');
       }
       flash()->addError('Failed user has not been approved');
          return redirect()->route('admin.user');
    }


    public function disApprove($userId)
    {
        $user = User::findOrFail($userId);
       if($user){
          $user->update(['email_verified_at' => null]);
          flash()->addSuccess('Successfully user has been disapproved');
          return redirect()->route('admin.user');
       }
       flash()->addError('Failed user has not been disapproved');
          return redirect()->route('admin.user');
    }

    public function subAdmin()
    {
        $subAdmins = SubAdmin::with('roleType')->get();
        return view('admin.permission.sub-admin', compact('subAdmins'));
    }


    public function approvedSubAdmin($userId)
    {
        $user = SubAdmin::findOrFail($userId);
       if($user){
          $user->update(['email_verified_at' => 1, 'token' => null]);
          flash()->addSuccess('Successfully sub admin has been approved');
          return redirect()->route('admin.sub_admin');
       }
       flash()->addError('Failed sub admin has not been approved');
          return redirect()->route('admin.sub_admin');
    }


    public function disApproveSubAdmin($userId)
    {
        $user = SubAdmin::findOrFail($userId);
       if($user){
          $user->update(['email_verified_at' => null]);
          flash()->addSuccess('Successfully sub admin has been disapproved');
          return redirect()->route('admin.sub_admin');
       }
       flash()->addError('Failed sub admin has not been disapproved');
          return redirect()->route('admin.sub_admin');
    }

    public function seller()
    {
        $sellers = Seller::with('roleType')->get();
        return view('admin.permission.seller', compact('sellers'));
    }


    public function approvedSeller($userId)
    {
        $user = Seller::findOrFail($userId);
       if($user){
          $user->update(['email_verified_at' => 1, 'token' => null]);
          flash()->addSuccess('Successfully seller has been approved');
          return redirect()->route('admin.seller');
       }
       flash()->addError('Failed seller has not been approved');
          return redirect()->route('admin.seller');
    }


    public function disApproveSeller($userId)
    {
        $user = Seller::findOrFail($userId);
       if($user){
          $user->update(['email_verified_at' => null]);
          flash()->addSuccess('Successfully seller has been disapproved');
          return redirect()->route('admin.seller');
       }
       flash()->addError('Failed seller has not been disapproved');
          return redirect()->route('admin.seller');
    }


    public function create($sellerId)
    {
       $permissions = Permission::with(['seller'=>fn($q)=>$q->where('seller_id', $sellerId)])->get();// here it filters within the relation 
       $seller = Seller::with('permissions')->findOrFail($sellerId);
      return view('admin.seller.create',compact('permissions','seller'));
    }

    public function store(Request $request,$sellerId)
    {
     $seller = Seller::findOrFail($sellerId);
     $selectedPermissions = $request->input('permissions',[]);
     $permissionId =   collect($selectedPermissions)->map(function ($permissionName){
      return Permission::firstOrCreate(['name'=>$permissionName])->id; 
      });

       $seller->permissions()->sync($permissionId);
     return redirect()->route('admin.seller');
    }


    

    
}
