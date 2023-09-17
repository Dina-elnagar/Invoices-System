<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        $sections=Section::all();
        return view('products.products',compact('sections'),compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        Product::create([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id,
        ]);
        session()->flash('Add','Added Successfully');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $products = Product::find($id);
        $sec_id = Section::where('section_name', $request->section_name)->first()->id;
        $products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $sec_id,
        ]);
        session()->flash('Edit', 'Edited Successfully');
        return redirect('/products');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product_id = Product::findOrFail($request->id);
        $product_id->delete();

        session()->flash('Delete', 'Deleted Successfully');
        return redirect('/products');
    }



}
