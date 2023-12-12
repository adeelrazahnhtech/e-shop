<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Jobs\SendEmailUserJob;
use App\Mail\RegisterUserEmail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function register()
    {
        $roles = Role::where('id',4)->get();
         return view('user.register',compact('roles'));
    }


    public function process(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();
        if(empty($validatedData)){
            return redirect()->route('user.register')->withInput($request->all());
        }
        $validatedData['token'] = uniqid();
        $user = User::create($validatedData);
 
        //queues
        dispatch(new SendEmailUserJob($user));
        return redirect()->route('user.register')->with('success','Account register please wait for account approval');
    }

    public function login()
    {
        return view('user.login');
    }


    public function attempt(AuthenticateUserRequest $request)
    {
        $validatedData = $request->validated();

        if(auth('user')->attempt(['email'=> $request->email,'password' => $request->password]))
        {
          $user =  auth('user')->user();
          if($user->role == 4 && $user->email_verified_at == 1)
          {
            return redirect()->route('user.profile');
          }else{
            return redirect()->route('user.login')->with('error','you are not authorized to access the user profile');
          }

        }else{
            return redirect()->route('user.login ')->with('error','Invalid Email/Password is incorrect');
        }

    }


    public function profile()
    {
        dd("okay");
        //showing the products
       return view('user.profile');
    }


    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('user.login')->with('success','Logged out successfully!');
    }

    
    
}
