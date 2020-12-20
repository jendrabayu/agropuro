<?php

namespace App\Http\Controllers;

use App\Category;
use App\Courier;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $titleName = 'Semua Produk';
        if ($request->has('serach')) $titleName = 'Hasil pencarian : ' . Str::limit($request->get('search'), 25);
        if ($request->has('category')) $titleName = 'Kategori ' . (Category::where('slug', $request->get('category'))->firstOrFail()->name);

        $products = $this->getProducts();

        $products->when($request->has('search'), function ($q) use ($request) {
            $q->where('nama', 'like', "%{$request->get('search')}%");
        });

        $products->when($request->has('category'), function ($q) use ($request) {
            $q->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->get('category'));
            });
        });

        $products->when($request->has('price'), function ($q) use ($request) {
            if ($request->get('price') === 'high-low') $q->orderByDesc('harga');
            if ($request->get('price') === 'low-high') $q->orderBy('harga');
        });

        $products->when($request->has('sort'), function ($q) use ($request) {
            if ($request->get('sort') === 'sales') $q->orderByDesc('sales');
            if ($request->get('sort') === 'time') $q->latest();
        });

        $categories = Category::all();
        $latestProduct = $this->getProducts()->latest()->take(9)->get();
        $salesProduct = $this->getProducts()->orderBy('sales', 'desc')->take(9)->get();
        $products = $products->paginate(9);

        return view('front.product.index', compact('categories', 'latestProduct', 'products', 'titleName', 'salesProduct'));
    }

    /**
     * Display the specified resource.
     * 
     * @param \App\Product $product
     * @return \Illuminate\View\View
     */
    public function show($id, $slug)
    {
        $categories = Category::all();
        $couriers = Courier::all();
        $relatedProducts = $this->getProducts()->inRandomOrder()->take(4)->get();
        $product = Product::query()->findOrFail($id);

        return view('front.product.show', compact('product', 'couriers', 'relatedProducts', 'categories'));
    }

    /**
     * Get products list from database.
     * 
     * @return \App\Product
     */
    private function getProducts()
    {
        return Product::where('diarsipkan', false)->where('stok', '>', 0)->withCount(['orderDetails as sales' => function ($q) {
            $q->select(DB::raw('IFNULL(SUM(quantity), 0)'))
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->where('orders.order_status_id', 5);
        }]);
    }
}
