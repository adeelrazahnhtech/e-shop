<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\StorePackageRequest;
use App\Http\Requests\admin\UpdatePackageRequest;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $packages = Package::orderBy('id','DESC')->get();
      return view('admin.package.list',compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
        $validatedData = $request->validated();
        Package::create($validatedData);
        return redirect()->route('packages.index')->with('success','package added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {

        return view('admin.package.edit',compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $validatedData = $request->validated();
        $package->update($validatedData);
        return redirect()->route('packages.index')->with('success','package updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('packages.index')->with('success','package deleted successfully');
    }
}
