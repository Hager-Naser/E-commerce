<?php

namespace App\Http\Controllers;

use App\Products;
use App\Sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        $sections = Sections::all();
        return view('products.products', compact("products", "sections"));
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
        $request->validate(
            [
                "product_name" => "required|max:99|unique:products,product_name",
                "notes" => "required|max:255",
                "section_id" => "required",
            ],
            [
                'product_name.required' => 'يرجى ادخال اسم المنتج',
                'product_name.max' => 'يرجى ادخال اسم المنتج بحد اقصى 99 حرف',
                'product_name.unique' => 'اسم المنتج مسجل سابقا   ',
                'notes.required' => 'يرجى ادخال  وصف المنتج',
                'notes.max' => 'يرجى ادخال وصف المنتج بحد اقصى 50 حرف',
                'section_id.required' => 'يرجى ادخال  وصف المنتج',
            ]
        );
        $products = Products::create(

            [
                "product_name" => $request->product_name,
                "notes" => $request->notes,
                "section_id" => $request->section_id,
            ]
        );
        session()->flash("add", "تم اضافة المنتج بنجاح");
        return redirect("/products");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;

        $Products = Products::findOrFail($request->id);

        $Products->update([
            'Product_name' => $request->Product_name,
            'notes' => $request->notes,
            'section_id' => $id,
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return redirect("/products");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $Products = Products::findOrFail($request->id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return redirect("/products");
    }
}
