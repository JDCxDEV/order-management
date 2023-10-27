<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('name', 'asc')->paginate(10);

        return view('pages.products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        Product::create([
            'name' => $request->name,
            'image_link' => $request->image_link,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('products.create')->with('success', 'Product has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('pages.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->only(['name', 'image_link']));
        return redirect()->route('products.show', $product->id)->with('success', "{$product->name} has been updated.");        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', "{$product->name} has been deleted.");  
    }

    /**
     * Get all resource from storage.
     */
    public function all()
    {
        $products = Product::orderBy('name', 'asc')->get();

        return response()->json([
            'products' => $products
        ]);
    }    
}
