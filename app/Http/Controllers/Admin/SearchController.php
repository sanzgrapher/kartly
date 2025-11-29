<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
        ]);

        $q = $validated['q'] ?? '';
        $categoryId = $validated['category_id'] ?? null;
        $minPrice = $validated['min_price'] ?? null;
        $maxPrice = $validated['max_price'] ?? null;

        $result = $this->searchService->multiSearch($q, $categoryId, $minPrice, $maxPrice);
        $allCategories = Category::orderBy('name')->get();

        return view('admin.search.index', [
            'q' => $result['query'],
            'categories' => $result['categories'],
            'products' => $result['products'],
            'allCategories' => $allCategories,
            'selectedCategoryId' => $categoryId,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }
}
