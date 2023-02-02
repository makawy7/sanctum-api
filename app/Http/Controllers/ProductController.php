<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response(Product::all(), 200);
    }
    public function show(Product $product)
    {
        return $product;
    }
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string|min:6',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);
        return Product::create($attributes);
    }

    public function update(Request $request, Product $product)
    {
        $attributes = $request->validate([
            'name' => 'sometimes|string|min:6',
            'price' => 'sometimes|numeric',
        ]);
        $product->update($attributes);
        return $product;
    }
    public function destroy(Product $product)
    {
        return $product->delete();
    }
}
