<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        $relatedProducts = collect();

        if ($product->category) {
            $relatedProducts = $product->category->products()
                ->where('id', '!=', $product->id)
                ->limit(4)
                ->get();
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(12);

        return view('products.index', compact('products'));
    }
}
