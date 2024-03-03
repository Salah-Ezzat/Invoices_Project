<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Laravel\Prompts\Prompt;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('sections', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required| max:255',
            'section_id' => 'required',
            'description' => 'required'
        ], [
            'product_name.required' => 'يرجى إدخال اسم المنتج',
            'section_id.required' => 'يرجى إدخال اسم القسم',
            'description.required' => 'يرجى ادخال الوصف',
        ]);

        Product::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description

        ]);
        session()->flash('add', 'تم إضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id= Section::where('section_name', $request->section_name)->first()->id;
        $this -> validate($request,[
            'product_name' => 'required| max:255',
            'section_name' => 'required',
            'description' => 'required'
        ], [
            'product_name.required' => 'يرجى إدخال اسم المنتج',
            'section_name.required' => 'يرجى إدخال اسم القسم',
            'description.required' => 'يرجى ادخال الوصف',
        ]);

        $products= Product::findOrFail($request->pro_id);
        $products->update([
            'product_name' => $request->product_name,
            'section_id' => $id,
            'description' => $request->description

        ]);
        session()->flash('edit','تم تعديل المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id= $request->id;
        Product::find($id)->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return redirect('/products');

    }
}
