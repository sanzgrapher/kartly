<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $search = request()->get('search');

        if ($search) {
            $categories = Category::search($search)
                ->paginate(12)
                ->withQueryString();
        } else {
            $categories = Category::withCount('products')
                ->orderBy('name')
                ->paginate(12);
        }

        return view('categories.index', compact('categories', 'search'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $category->products()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
