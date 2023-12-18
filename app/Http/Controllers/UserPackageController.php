<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\UserPackage;
use Illuminate\Http\Request;

class UserPackageController extends Controller
{
    public function index()
    {
       $packages = Package::all();
       return view('user.package.list',compact('packages'));
    }

    public function createPackage(Package $packageId)
    {
        $amount = $packageId->price;
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                    $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'USD',
                            'product_data' => [
                                'name' => 'Package',
                            ],
                            'unit_amount' => $amount * 100 ,
                        ],
                        'quantity' => 1,
                    ]],
                    'customer_email' => auth('user')->user()->email,
                
                'metadata' => [
                    'package' => $packageId->id,
                    'user' => auth('user')->user()->id,
                ],
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
                
            ]);
          
            return redirect($checkout_session->url);
            // return response()->json(['id' => $session->url]);
           
        } catch (\Throwable $th) {
                    return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }

    }


    public function storePackage()
    {
    $checkout_session_id = $_GET['session_id'];

    try {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($checkout_session_id);
        if(UserPackage::where('payment_id',$session->payment_intent)->exists()){
            flash()->addError('invalid request payment already exists on this session id');
                return redirect()->route('user.package');
        }
        UserPackage::create(['user_id' => $session->metadata->user, 'package_id'=>$session->metadata->package, 'payment_id' =>$session->payment_intent  ]);
            flash()->addSuccess('Thank you for subscribing to our platform :)');
            return redirect()->route('user.profile');
               
       
    } catch (\Throwable $th) {
                return response()->json(['status' => false, 'error' => $th->getMessage()]);
    }
    }

    public function cancelPackage()
    {
        flash()->addSuccess('Package has been cancelled');
        return redirect()->route('user.package');
    }
}
