<?php

namespace App\Http\Controllers\Admin;

use App\{BankAccount, Category};
use App\Http\Requests\Product\{ProductStoreRequest, ProductUpdateRequest};
use App\DataTables\Admin\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Product;
use App\ShopAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\Admin\ProductDataTable $productDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ProductDataTable $productDataTable)
    {
        return  $productDataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (ShopAddress::all()->isEmpty()) {
            return redirect()->route('admin.shop-address')->with('warning', 'Alamat Toko Belum Diatur');
        }

        if (BankAccount::all()->isEmpty()) {
            return redirect()->route('admin.bank-account.index')->with('warning', 'Rekening Toko Belum Ada');
        }

        return view('admin.product.create', [
            'categories' => Category::all()->pluck('name', 'id')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', [
            'categories' => Category::all()->pluck('name', 'id'),
            'product' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Product\ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['gambar'] = $request->file('gambar')->store('images/product', 'public');

        Product::create($validated);
        return back()->with('info', 'Berhasil Menambahkan Produk Baru');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        abort_if(!request()->ajax(), 401, 'Unauthorized');

        if (!Str::contains($product->gambar, 'dummy.jpg')) {
            Storage::disk('public')->delete($product->gambar);
        }
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Produk Berhasil Dihapus'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Product\ProductUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('images/product', 'public');
            if ($validated['gambar'] && !Str::contains($product->gambar, 'dummy.jpg')) {
                Storage::disk('public')->delete($product->gambar);
            }
        }

        $product->update($validated);
        return back()->with('info', 'Data Produk Berhasil Diubah');
    }

    /**
     * Set product to archived or unarchived
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function setArchived(Request $request, Product $product)
    {
        abort_if(!$request->ajax(), 401, 'Unauthorized');

        $validated = $this->validate($request, ['diarsipkan' => ['required', 'boolean']]);

        $product->update($validated);
        return response()->json([
            'success' => true,
            'message' => $product->diarsipkan === true ? 'Produk Diarsipkan' : 'Product Ditampilkan'
        ], 200);
    }
}
