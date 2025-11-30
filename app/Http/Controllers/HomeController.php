<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\Products\Contracts\RecommendationServiceInterface;

class HomeController extends Controller
{
    public function __construct(
        private RecommendationServiceInterface $recommendationService
    ) {}

    public function index()
    {
        $categories = Category::with('products')->limit(6)->get();

        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $recommendations = $this->recommendationService->getHomePageRecommendations(auth()->id());

        return view('home', compact('categories', 'products', 'recommendations'));
    }
}
