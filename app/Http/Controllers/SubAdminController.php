<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateSubAdminRequest;
use App\Http\Requests\RegisterSubAdminRequest;
use App\Mail\RegisterSubAdminEmail;
use App\Mail\RegisterUserEmail;
use App\Models\Role;
use App\Models\SubAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SubAdminController extends Controller
{
    public function register()
    {
        $roles = Role::where('id',2)->get();
         return view('sub-admin.register',compact('roles'));
    }

    public function process(RegisterSubAdminRequest $request)
    {
        $validatedData = $request->validated();
        if(empty($validatedData)){
            return redirect()->route('sub_admin.register')->withInput($request->all());
        }
        $validatedData['token'] = uniqid();
        $user = SubAdmin::create($validatedData);

        Mail::to($user->email)->send(new RegisterUserEmail($user));
        return redirect()->route('sub_admin.register')->with('success','Account register please wait for account approval');

    }

    public function login()
    {
      return view('sub-admin.login');
    }

    public function attempt(AuthenticateSubAdminRequest $request)
    {
        $validatedData = $request->validated();

        if(auth('sub_admin')->attempt(['email'=> $request->email,'password' => $request->password]))
        {
          $sub_admin =  auth('sub_admin')->user();
          if($sub_admin->role == 2 && $sub_admin->email_verified_at == 1)
          {
            return redirect()->route('sub_admin.dashboard');
          }else
          {
            return redirect()->route('sub_admin.login')->with('error','you are not authorized to access the sub admin panel');
          }

        }else
        {
            return redirect()->route('sub_admin.login ')->with('error','Invalid Email/Password is incorrect');
        }

    }


    public function dashboard()
    {
      return view('sub-admin.dashboard');
    }

    public function logout()
    {
        Auth::guard('sub_admin')->logout();
        return redirect()->route('sub_admin.login')->with('success','Logged out successfully!');
    }
}
