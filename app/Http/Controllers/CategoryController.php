<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $categories = Category::all();
       return view('admin.category.list',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
      $validatedData = $request->validated();

      if(!empty($validatedData)){

       
        if(!empty($request->hasFile('image'))){
            $image = $request->file('image');
            $imageName = time().".".$image->getClientOriginalExtension();
            $image->move(public_path("uploads/category/"),$imageName);

            $validatedData['image'] = $imageName;
           }
           Category::create($validatedData);
           return redirect()->route('categories.index')->with('success','Category added successfully');
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
    public function edit(string $categoryId)
    {
        $category = Category::find($categoryId);
        if(empty($category)){
            return redirect()->route('categories.index');
        }
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $categoryId)
    {
        $category = Category::find($categoryId);
        if(empty($category)){
            return redirect()->route('categories.index');
        }else{

            $validatedData = $request->validated();
            if(!empty($request->hasFile('image'))){
                $image = $request->file('image');
                $imageName = time().".".$image->getClientOriginalExtension();
                $image->move(public_path("uploads/category/"),$imageName);
    
                $validatedData['image'] = $imageName;
    
               }else{
                $validatedData['image'] = $request->existing_image;
   
               }
            $category->update($validatedData);
            // addSuccess('success: Category updated successfully');
            return redirect()->route('categories.index');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $categoryId)
    {
        $category = Category::find($categoryId);
        if(empty($category)){
            return redirect()->route('categories.index');
        }
        File::delete("uploads/category/".$category->image);
        $category->delete();
        flash()->addSuccess('success: Category deleted successfully');
        return redirect()->route('categories.index');
       
    }
}
