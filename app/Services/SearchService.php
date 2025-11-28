<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

class SearchService
{
    
    public function multiSearch(string $query, int $categoryLimit = 12, int $productPerPage = 12): array
    {
        $query = trim($query);

        if ($query === '') {
            return [
                'categories' => Category::orderBy('name')->limit($categoryLimit)->get(),
                'products' => Product::orderBy('created_at', 'desc')->paginate($productPerPage),
                'query' => '',
            ];
        }

        // Search categories
        $categories = Category::search($query)
            ->take($categoryLimit)
            ->get();

        // Search products (searches in: name, description, category_name)
        $products = Product::search($query)
            ->paginate($productPerPage)
            ->withQueryString();

        return [
            'categories' => $categories,
            'products' => $products,
            'query' => $query,
        ];
    }
}
