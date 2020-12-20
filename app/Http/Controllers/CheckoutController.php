<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Category;
use App\Courier;
use App\ShopAddress;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next) {
            $address = auth()->user()->addresses()->where('is_main', true)->get();
            $shopAddress = ShopAddress::all();
            $carts = auth()->user()->carts()->get();

            if ($address->isEmpty()) {
                return redirect()->route('customer.address.index')->with('warning', 'Anda Harus Mengatur Alamat Utama Terlebih Dahulu');
            }

            if ($carts->isEmpty()) {
                return redirect()->route('cart.index')->with('warning', 'Keranjang Anda Kosong');
            }

            if ($shopAddress->isEmpty()) {
                return redirect()->route('cart.index')->with('warning', 'Alamat Toko Belum Diatur, Hubungi Admin!');
            }

            return $next($request);
        });
    }


    /**
     * 
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        $categories = Category::all();
        $bankAccounts = BankAccount::all();
        $couriers = Courier::all();
        $shopAddress = ShopAddress::first();

        $carts = auth()->user()->carts;
        $address = auth()->user()->addresses()->where('is_main', true)->first();
        $weight = collect($carts)->sum(fn ($q) => $q->quantity * $q->product->berat);
        $subTotal = collect($carts)->sum(fn ($q) => $q->quantity * $q->product->harga);

        if ($weight > 30000) {
            return back()->with('warning', 'Berat Total Tidak Boleh Lebih Dari 30Kg');
        }

        $costs = [];

        foreach ($couriers as $courier) {
            try {
                $cost =  Http::withHeaders([
                    'Key' => env('API_KEY_RAJA_ONGKIR', '206cc2aef17ad58f99012341e0759692')
                ])->post('https://api.rajaongkir.com/starter/cost', [
                    'origin' => $shopAddress->city_id,
                    'destination' => $address->city_id,
                    'weight' => intval($weight),
                    'courier' => $courier->code
                ]);
                array_push($costs, $cost['rajaongkir']['results'][0]);
            } catch (\Exception $e) {
                abort(500, 'Connection Timeout');
            }
        }

        return view('front.checkout', compact('categories', 'subTotal', 'carts', 'bankAccounts', 'address', 'costs', 'weight'));
    }
}
