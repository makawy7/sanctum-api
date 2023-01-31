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
    public function show()
    {
        return '0000000000';
    }
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string|min:6',
            'price' => 'required',
            'description' => 'required'
        ]);
        Product::create($attributes);
    }

    public function update()
    {
        return '0000000000';
    }
    public function destroy()
    {
        return '0000000000';
    }
}
