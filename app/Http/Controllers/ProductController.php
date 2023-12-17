<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminProductRequest;
use App\Http\Requests\UpdateAdminProductRequest;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     //admin
    public function index()
    {
        // $products = Product::with('reviews','categoryWise','adminType.roleType','subAdminType.roleType','sellerType.roleType')->orderByDesc('id')->get();
        $products = Product::with('reviews','categoryWise','productable.roleType')->orderByDesc('id')->get();

        return view('admin.product.list',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::orderBy('name','ASC')->get();
        $data['categories'] = $category; 
        return view('admin.product.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminProductRequest $request)
    {

        $validatedData = $request->validated();
        
        if(auth('admin')->check()){
            $user = auth('admin')->user();
            $validatedData['product_created'] = auth('admin')->user()->roleType->role_type;
        }elseif (auth('sub_admin')->check()) {
            $user = auth('sub_admin')->user();
            $validatedData['product_created'] = auth('sub_admin')->user()->roleType->role_type;

        }elseif (auth('seller')->check()){
            // authorize logics in product policy
            // $this->authorize('store',Product::class);

            $user = auth('seller')->user();
            $validatedData['product_created'] = auth('seller')->user()->roleType->role_type;
        }

        $user->product()->create($validatedData);

        if(auth('admin')->check()){
            flash()->addSuccess('Successfully product created');
            return redirect()->route('products.index');
        }elseif (auth('sub_admin')->check()) {
            flash()->addSuccess('Successfully product created');
            return redirect()->route('sub_admin.products.index');
        }elseif (auth('seller')->check()){
            flash()->addSuccess('Successfully product created');
            return redirect()->route('seller.products.index');
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $productId)
    {
       $product = Product::findOrFail($productId);
       $category = Category::orderBy('name','ASC')->get();
        $data['product'] = $product; 
        $data['categories'] = $category; 
        
        if (empty($product)) {
            flash()->addError('Data is empty');
            return redirect()->route('products.index');
        }
        return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminProductRequest $request, string $productId)
    {   

        $product = Product::findOrFail($productId);
        if (empty($product)) {
            flash()->addError('Data is empty');
            return redirect()->route('products.index');
        }
        $validatedData = $request->validated();
        if(auth('admin')->check()){
            $user = auth('admin')->user();
            $validatedData['product_created'] = auth('admin')->user()->roleType->role_type;
        }elseif (auth('sub_admin')->check()) {
            $user = auth('sub_admin')->user();
            $validatedData['product_created'] = auth('sub_admin')->user()->roleType->role_type;

        }elseif (auth('seller')->check()){
            $user = auth('seller')->user();
            $validatedData['product_created'] = auth('seller')->user()->roleType->role_type;
        }

        $product->$user->product()->update($validatedData);

        if(auth('admin')->check()){
            flash()->addSuccess('Successfully product updated');
            return redirect()->route('products.index');
        }elseif (auth('sub_admin')->check()) {
            flash()->addSuccess('Successfully product updated');
            return redirect()->route('sub_admin.products.index');
        }elseif (auth('seller')->check()){
            flash()->addSuccess('Successfully product updated');
            return redirect()->route('seller.products.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $productId)
    {
        $product = Product::findOrFail($productId);
         
         if (empty($product)) {
             flash()->addError('Data is empty');
             return redirect()->route('products.index');
         }
         $product->delete();
         flash()->addSuccess('product deleted successfully');
         return redirect()->route('products.index');
    }

    //sub admin
    public function subAdminIndex()
    {
        // $products = Product::with(['reviews','categoryWise','subAdminType.roleType'])->whereHas('subAdminType.roleType', fn($q)=>$q->where('id', 2))->orderByDesc('id')->get();
        $products = Product::with('reviews','categoryWise','productable.roleType')->orderByDesc('id')->get();
       
        return view('sub-admin.product.list',compact('products'));
    }

    public function subAdminCreate()
    {
        $categories = Category::orderBy('name','ASC')->get();
        return view('sub-admin.product.create',compact('categories'));
    }

    public function subAdminEdit($productId)
    {
        $product = Product::findOrFail($productId);
        $category = Category::orderBy('name','ASC')->get();
         $data['product'] = $product; 
         $data['categories'] = $category; 
         
         if (empty($product)) {
             flash()->addError('Data is empty');
             return redirect()->route('sub_admin.products.index');
         }
         return view('sub-admin.product.edit',$data);
     }

     public function subAdminDestroy($productId)
     {
        $product = Product::findOrFail($productId);
         
        if (empty($product)) {
            flash()->addError('Data is empty');
            return redirect()->route('sub_admin.products.index');
        }
        $product->delete();
        flash()->addSuccess('product deleted successfully');
        return redirect()->route('sub_admin.products.index');

     }


     //seller
     public function sellerIndex()
     {
        // $products = Product::with('reviews','categoryWise','productable.roleType')->whereHas('productable', fn($q)=>$q->where('id', 3))->get();
        $products = Product::with('reviews','categoryWise','productable.roleType')->orderByDesc('id')->get();
        return view('seller.product.list',compact('products'));
     }


     
     public function sellerCreate()
     {
         $categories = Category::orderBy('name','ASC')->get();
         return view('seller.product.create',compact('categories'));
     }


     public function sellerEdit($productId)
     {
           // authorize logics in product policy
        // $this->authorize('update',Product::class);

         $product = Product::findOrFail($productId);
         $category = Category::orderBy('name','ASC')->get();
          $data['product'] = $product; 
          $data['categories'] = $category; 
          
          if (empty($product)) {
              flash()->addError('Data is empty');
              return redirect()->route('sub_admin.products.index');
          }
          return view('seller.product.edit',$data);
      }

      public function sellerDestroy($productId)
      {
         //authorize logics in seller policy
         $this->authorize('delete',Product::class);

        $product = Product::findOrFail($productId);
         
        if (empty($product)) {
            flash()->addError('Data is empty');
            return redirect()->route('seller.products.index');
        }
        $product->delete();
        flash()->addSuccess('product deleted successfully');
        return redirect()->route('seller.products.index');
      }

}
