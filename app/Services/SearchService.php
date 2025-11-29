<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

class SearchService
{

    public function multiSearch(
        string $query,
        ?int $categoryId = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        int $categoryLimit = 12,
        int $productPerPage = 12
    ): array {
        $query = trim($query);

        if ($query === '' && ($categoryId || $minPrice !== null || $maxPrice !== null)) {
            $productsQuery = Product::query();

            if ($categoryId) {
                $productsQuery->where('category_id', $categoryId);
            }

            if ($minPrice !== null) {
                $productsQuery->where('price', '>=', $minPrice * 100); // Convert to cents
            }

            if ($maxPrice !== null) {
                $productsQuery->where('price', '<=', $maxPrice * 100); // Convert to cents
            }

            return [
                'categories' => Category::orderBy('name')->limit($categoryLimit)->get(),
                'products' => $productsQuery->orderBy('created_at', 'desc')->paginate($productPerPage)->withQueryString(),
                'query' => '',
            ];
        }

        if ($query === '') {
            return [
                'categories' => Category::orderBy('name')->limit($categoryLimit)->get(),
                'products' => Product::orderBy('created_at', 'desc')->paginate($productPerPage),
                'query' => '',
            ];
        }

        $categories = Category::search($query)
            ->take($categoryLimit)
            ->get();

        $searchQuery = Product::search($query);

        $filters = [];

        if ($categoryId) {
            $filters[] = "category_id:=$categoryId";
        }

        if ($minPrice !== null) {
            $filters[] = "price:>=" . ($minPrice * 100);
        }

        if ($maxPrice !== null) {
            $filters[] = "price:<=" . ($maxPrice * 100);
        }

        if (!empty($filters)) {
            $searchQuery->options(['filter_by' => implode(' && ', $filters)]);
        }

        // dd($searchQuery);
        $products = $searchQuery
            ->paginate($productPerPage)
            ->withQueryString();

            // dd($products);

        return [
            'categories' => $categories,
            'products' => $products,
            'query' => $query,
        ];
    }
}
