<?php

namespace App\Http\Controllers;

use App\Http\Requests\GiveReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    public function index()
    {
      $reviews = Review::with('reviewable.roleType','product')->orderByDesc('rating')->get();
    //   dd($reviews);
      return view('admin.review.list',compact('reviews'));
    }
    public function create($productId)
    {
        $product = Product::find($productId);
        return view('user.review.create',compact('product'));
    }


    public function createAdmin($productId)
    {
        $product = Product::with('orders')->find($productId);
        if($product->sub_admin != null || $product->seller != null ){
            flash()->addError('You are not authorized to give the review');
            return redirect()->back();
        }
        return view('admin.review.create',compact('product'));
    }


    public function createSubadmin($productId)
    {
        $product = Product::with('orders')->find($productId);
        return view('sub-admin.review.create',compact('product'));
    }


    public function createSeller($productId)
    {
        $product = Product::with('orders')->find($productId);
        return view('seller.review.create',compact('product'));
    }


    public function store(GiveReviewRequest $request)
    {
        if (auth('admin')->check())
        {
            $user = auth('admin')->user();
            
        }elseif (auth('sub_admin')->check()) 
        {
            $user = auth('sub_admin')->user();
            
        }elseif (auth('seller')->check()){
            $user = auth('seller')->user();
        }else
        {
            $user = auth('user')->user();
        }

        $validatedData = $request->validated();
        $user->reviews()->create($validatedData);
        flash()->addSuccess('Successfully review added');

            if(auth('admin')->check()){
            return redirect()->route('products.index');
            }elseif (auth('sub_admin')->check()){
            return redirect()->route('sub_admin.products.index');
            }elseif (auth('seller')->check()){
            return redirect()->route('seller.products.index');
            }else{
                return redirect()->route('user.profile');
            }
    }

    public function approve($reviewId)
    {
        $review =  Review::findOrFail($reviewId);
        $review->update(['status' => 1]);
        flash()->addSuccess('Review has been approved.');
        return redirect()->back();
    }


    public function disApprove($reviewId)
    {
      $review =  Review::findOrFail($reviewId);
      $review->update(['status' => 0]);
      flash()->addSuccess('Review has been disapproved.');
      return redirect()->back();
    }

}
