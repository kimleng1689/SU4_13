<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Rules\NumberFormat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Product::create( $request->all() );
        // Product::create([
        //     'product_name' => $request->product_name,
        //     'price' => $request->price,
        //     'warranty' => $request->warranty,
        //     'quantity' => $request->quantity,
        //     'description' => $request->description,
        // ]);

        $request->validate([
            'product_name' => 'required|min:2|max:100|unique:products,product_name',
            'price' => 'required|numeric',
            'warranty' => 'numeric',
            'quantity' => 'numeric',
            'description' => 'required'
        ]);

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->warranty = $request->warranty;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->save();

        return redirect('/products/create')->with('success', 'The product has been created successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => [
                'required', 
                'min:2', 
                'max:100', 
                Rule::Unique("products", 'product_name')->ignore($id),
                
            ],
            'price' => ['required', new NumberFormat(),],
            'warranty' => 'numeric',
            'quantity' => 'numeric',
            'description' => 'required'
        ]);
       

        $product = Product::find($id);
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->warranty = $request->warranty;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->save();

        return redirect('/products')->with('success', 'The product has been updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index')->with('success', 'The product has been deleted successfully.');
    }
    public function remove($id) {
        Product::find($id)->delete();
        return redirect('/products')->with('success', 'The product has been deleted successfully.');
    }
    public function confirmDeletion($id) {
        return  redirect()
                ->route('products.index')
                ->with('id', $id);
    }
    public function searchForm() {
        return view('products.search');
    }
}
