<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSubAdminRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class SubAdminController extends Controller
{
    public function register()
    {
        $roles = Role::where('id' ,'=',2)->get();
         return view('sub-admin.register',compact('roles'));
    }

    public function process(RegisterSubAdminRequest $request)
    {
        $validatedData = $request->validated();
        if($validatedData){
            
        }

    }
}
