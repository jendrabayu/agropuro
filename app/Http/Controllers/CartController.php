<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('front.cart', [
            'carts' => auth()->user()->carts,
            'categories' => Category::all()
        ]);
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $product->stok]
        ]);

        $cart = auth()->user()->carts()->where('product_id',  $product->id)->first();

        if ($cart && ($request->quantity + $cart->quantity) > $product->stok) {
            return back()->with('warning', 'Stok Tidak Mencukupi');
        }

        if ($cart) {
            $cart->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('cart.index')
            ->with('info', 'Berhasil Menambahkan Produk Ke Keranjang');
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate(['carts' => 'array|required']);

        foreach ($request->carts as $item) {
            $product = Product::where('id', $item['product_id'])->first();
            $cart = auth()->user()->carts()->where('product_id', $item['product_id'])->first();

            if ($item['quantity'] < 1) {
                $cart->delete();
                continue;
            }

            if ($item['quantity'] > $product->stok) {
                $cart->update(['quantity' => $product->stok]);
                continue;
            }

            $cart->update(['quantity' => $item['quantity']]);
        }

        return response()->json(['success' => true], 200);
    }

    /**
     * 
     * @param \App\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(['success' => true], 200);
    }
}
