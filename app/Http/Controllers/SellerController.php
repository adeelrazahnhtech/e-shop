<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateSellerRequest;
use App\Http\Requests\RegisterSellerRequest;
use App\Mail\RegisterUserEmail;
use App\Models\Role;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SellerController extends Controller
{
    public function register()
    {
        $roles = Role::where('id',3)->get();
         return view('seller.register',compact('roles'));
    }


    public function process(RegisterSellerRequest $request)
    {
        $validatedData = $request->validated();
        if(empty($validatedData)){
            return redirect()->route('seller.register')->withInput($request->all());
        }
        $validatedData['token'] = uniqid();
        $seller = Seller::create($validatedData);

        Mail::to($seller->email)->send(new RegisterUserEmail($seller));
        return redirect()->route('seller.register')->with('success','Account register please wait for account approval');
    }


    public function login()
    {
        return view('seller.login');
    }

    public function attempt(AuthenticateSellerRequest $request)
    {
        $validatedData = $request->validated();
        dd($validatedData);

        if(auth('seller')->attempt(['email'=> $request->email,'password' => $request->password]))
        {
          $seller =  auth('seller')->user();
          if($seller->role == 3 && $seller->email_verified_at == 1)
          {
            return redirect()->route('seller.dashboard');
          }else
          {
            return redirect()->route('seller.login')->with('error','you are not authorized to access the seller panel');
          }

        }else
        {
            return redirect()->route('seller.login ')->with('error','Invalid Email/Password is incorrect');
        }


    }

    public function dashboard()
    {
        return view('seller.dashboard');

    }

    public function logout()
    {
        Auth::guard('seller')->logout();
        return redirect()->route('seller.login')->with('success','Logged out successfully!');
    }
}
