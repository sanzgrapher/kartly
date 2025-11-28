<?php

namespace App\Http\Controllers;

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
            'q' => 'nullable|string|max:255'
        ]);

        $q = $validated['q'] ?? '';

         $result = $this->searchService->multiSearch($q);

        return view('search.index', [
            'q' => $result['query'],
            'categories' => $result['categories'],
            'products' => $result['products'],
        ]);
    }
}
