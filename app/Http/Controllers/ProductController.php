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
        $products = Product::all();
        $sections = Section::all();
        return view('products.products')->with(['products'=>$products , 'sections'=>$sections ]);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name'=>'required|string',
            'description'=>'max:999|string',
            'section_id'=>'required|exists:sections,id'
        ]);
        Product::create([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id
        ]);
        session()->flash('product_add_success',"Product Added Successfully");
        return redirect()->back();
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'product_name_update'=>'required|string',
            'description_update'=>'max:500|string',
            'section_id_update'=>'required|exists:sections,id'
        ]);
        $product->update(['product_name'=>$request->product_name_update,
        'description'=>$request->description_update,'section_id'=>$request->section_id_update]);
 
                          
                          
     session()->flash('product_update_success',"Product Updated successfully");
 
     return redirect()->back();
    }

    public function delete ($id){
        $product = Product::findOrFail($id);
        $product->delete();
        session()->flash('product_delete_success',"Product Deleted successfully");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
