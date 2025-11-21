<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => 'nullable|string|max:255'
        ]);
        $q = trim($validated['q'] ?? '');


        if ($q !== '') {
            $categories = Category::where('name', 'like', "%{$q}%")
                ->orderBy('name')
                ->get();

            $products = Product::where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")
                ->orWhereHas('category', function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(12)
                ->withQueryString();
        } else {
             $categories = Category::orderBy('name')->limit(12)->get();
            $products = Product::orderBy('created_at', 'desc')->paginate(12);
        }

        return view('search.index', compact('q', 'categories', 'products'));
    }
}
