<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Products\Contracts\RecommendationServiceInterface;

class ProductController extends Controller
{
    public function __construct(
        private RecommendationServiceInterface $recommendationService
    ) {}

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        $this->recommendationService->trackInteraction(
            $product->id,
            auth()->id(),
            'view',
            session()->getId()
        );

        $relatedProducts = $this->recommendationService->getRecommendationsForProduct($product, 4);

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(12);

        return view('products.index', compact('products'));
    }
}
