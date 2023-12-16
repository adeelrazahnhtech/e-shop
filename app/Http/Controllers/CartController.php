<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{

    public function index()
    {
        $cartContents = \Cart::getContent();
        return view('user.cart',compact('cartContents'));
    }
    
    public function create(Product $product)
    {

        try {
            \Cart::add([
                'id' => $product->id, // inique row ID
                'name' => $product->title,
                'price' => $product->price,
                'quantity' => 1,
            ]);
            flash()->addSuccess('Successfully added the product to your cart ');
            return redirect()->route('user.profile');
        } catch (\Exception $e) {
            flash()->addError($e->getMessage());
            return redirect()->route('user.profile');
        }
    }

    public function update(Request $request, $product)
    {
        try{
        $product  =  \Cart::get($product);
        // dd($product);
                // \Cart::update($product->id,[
                // 'name' => $product->name,
                // 'price' => $product->price,
                // 'quantity' => $request->quantity,
            Cart::remove($product->id);
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
            ]);
            flash()->addSuccess('Successfully updated the product in your cart');
            return redirect()->route('user.cart');
        } catch (\Throwable $th) {
            flash()->addError($th->getMessage());
            return redirect()->route('user.cart');
        }
    }


    public function destroy($product)
    {
        \Cart::get($product);
        \Cart::remove($product);
        flash()->addSuccess('Successfully deleted the item to your cart');
        return  redirect()->route('user.cart');
    }


    public function createOrder()
    {
        $items = \Cart::getContent();
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $line_items = [];

            foreach ($items as $key => $value) {
                $line_items[] = [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                            'name' => $value->name,
                             ],
                            'unit_amount' => $value['price'] * 100,
                        ],
                        'quantity' => $value['quantity'],
                    ];
            }
            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => $line_items,
                'metadata' => ['items'=>json_encode($items)],
                'customer_email' => auth('user')->user()->email,
                'mode' => 'payment',
                'success_url' => route('order.pay').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('order.cancel') . '/?cancel',
            ]);
           return redirect($checkout_session->url);
            //code...
        } catch (\Exception $e) {
            flash()->addError($e->getMessage());
            return redirect()->route('user.cart');
        }
    }


    public function storeOrder()
    {
        $order_session_id = $_GET['session_id'];
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $session = $stripe->checkout->sessions->retrieve($order_session_id);
            if(Order::where('payment_id',$session->payment_intent)->exists()) 
            {
                flash()->addError('invalid request order already exists on this session id');
                return redirect()->route('user.profile');
            }
            $order = Order::create(['user_id' => auth('user')->user()->id,'status'=> $session->payment_status,'payment_id' =>$session->payment_intent]);
                
            $cartItems  = \Cart::getContent();
            foreach ($cartItems as $cartItem) {
               $product = Product::find($cartItem->id);
               $order->products()->attach($product,['quantity' => $cartItem->quantity]);
            }
            \Cart::clear();
          
            flash()->addSuccess('Thank you for ordering to our product :)');
            return redirect()->route('user.profile');
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    public function cancelOrder()
    {
        flash()->addSuccess('Your payment has been cancelled');
        return redirect()->route('user.cart');
    }


    public function order()
    {
        $orders = Order::with('products')->get();
        return view('user.order',compact('orders'));
    }


    public function show(Order $orderId)
    {
        $orders = Order::with('products')->find($orderId);
        return view('user.view-products',compact('orders'));

    }


    
}
