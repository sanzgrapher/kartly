<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        if ($search) {
            $categories = Category::search($search)
                ->paginate(10)
                ->withQueryString();
        } else {
            $categories = Category::orderBy('name')
                ->paginate(10);
        }

        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {

        $request['slug'] = $request['slug'] ?? $request['name'];
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255',
        ]);
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);



        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(10);

        $stats = [
            'products_count' => $category->products()->count(),
            'total_value' => $category->products()->sum('price'),
        ];

        return view('admin.categories.show', compact('category', 'products', 'stats'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request['slug'] = $request['slug'] ?? $request['name'];

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'slug' => 'nullable|string|max:255',
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted');
    }
}
