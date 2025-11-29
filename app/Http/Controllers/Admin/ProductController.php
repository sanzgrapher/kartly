<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $categoryId = $request->get('category_id');
        $stockStatus = $request->get('stock_status');
        $stockLow = $request->get('stock_low');
        $stockHigh = $request->get('stock_high');

        if ($search) {
            $query = Product::search($search);

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            if ($stockStatus === 'in_stock') {
                $query->where('quantity', ['>=', 10]);
            } elseif ($stockStatus === 'low_stock') {
                $query->where('quantity', ['>=', 1])->where('quantity', ['<=', 9]);
            } elseif ($stockStatus === 'out_of_stock') {
                $query->where('quantity', 0);
            }

            if ($stockLow) {
                $query->where('quantity', ['>=', (int) $stockLow]);
            }
            if ($stockHigh) {
                $query->where('quantity', ['<=', (int) $stockHigh]);
            }

            $products = $query->paginate(10)->withQueryString();
        } else {
            $query = Product::query();

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            if ($stockStatus === 'in_stock') {
                $query->where('quantity', '>=', 10);
            } elseif ($stockStatus === 'low_stock') {
                $query->whereBetween('quantity', [1, 9]);
            } elseif ($stockStatus === 'out_of_stock') {
                $query->where('quantity', 0);
            }

            if ($stockLow) {
                $query->where('quantity', '>=', $stockLow);
            }
            if ($stockHigh) {
                $query->where('quantity', '<=', $stockHigh);
            }

            $products = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        }

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request['slug'] = $request['slug'] ?? $request['name'];

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);


        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $product = Product::findOrFail($id);
        $request['slug'] = $request['slug'] ?? $request['name'];
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $id,
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }


    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'adjustment' => 'required|integer',
        ]);
        $adjustment = $data['adjustment'];
        $newQuantity = $product->quantity + $adjustment;

        if ($newQuantity < 0) {
            return redirect()
                ->back()
                ->with('error', 'Cannot remove more stock than available. Current stock: ' . $product->quantity);
        }

        $product->quantity = $newQuantity;
        $product->save();

        $action = $adjustment > 0 ? 'added' : 'removed';
        $amount = abs($adjustment);

        return redirect()
            ->back()
            ->with('success', "Successfully {$action} {$amount} units. New stock: {$newQuantity}");
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
