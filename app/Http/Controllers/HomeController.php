<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
   
    public function index()
    {
          
        $categories = Category::with('products')->limit(6)->get();

        
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('home', compact('categories', 'products'));
    }
}
