<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $category->products()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
