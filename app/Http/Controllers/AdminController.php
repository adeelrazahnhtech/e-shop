<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
       return view('admin.login');
    }

    public function attempt(LoginAdminRequest $request)
    {
        $validatedData = $request->validated();
        if(empty($validatedData)){
            return redirect()->route('admin.login')->withErrors($validatedData)->withInput($request->only('email'));
        }
        if(auth('admin')->attempt([ 'email' => $request->email, 'password'=> $request->password])){
             $admin = auth()->guard('admin')->user();
            if($admin->role == 1){
                return redirect()->route('admin.dashboard');
            }else{
                $admin->logout();
                return redirect()->route('admin.login')->with('error','you are not authorized to use access the admin panel');
            }

        }else{
         return redirect()->route('admin.login')->with('error','Invalid Email/password is incorrect');
        }

    }
 
    public function dashboard()
    {
      return view('admin.dashboard');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','Logged out successfully!');
    }
}
