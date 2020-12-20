<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopAddress\{ShopAddressStoreRequest, ShopAddressUpdateRequest};
use App\Province;
use App\ShopAddress;

class ShopAddressController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        if (ShopAddress::all()->isEmpty()) {
            return view('admin.shop-address.create', [
                'provinces' => Province::all()->pluck('name', 'province_id')
            ]);
        }

        return view('admin.shop-address.edit', [
            'address' => ShopAddress::first(),
            'provinces' => Province::all()->pluck('name', 'province_id'),
            'cities' => ShopAddress::first()->city->province->cities
        ]);
    }

    /**
     * Get all city by province id
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities($id)
    {
        abort_if(!request()->ajax(), 401, 'Unauthorized');

        $cities = City::where('province_id', $id)->get();

        return response()->json($cities, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Address\StoreAddressRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopAddressStoreRequest $request)
    {
        if (ShopAddress::all()->isNotEmpty()) {
            return  redirect()->route('shop.address.edit');
        }

        $validated = $request->validated();
        ShopAddress::create($validated);
        return back()->with('info', 'Berhasil Mengatur Alamat Toko');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\ShopAddressUpdateRequest $request
     * @param  \App\ShopAddress $shopAddress
     * @return \Illuminate\Http\Response
     */
    public function update(ShopAddressUpdateRequest $request, ShopAddress $shopAddress)
    {
        $validated = $request->validated();
        $shopAddress->update($validated);
        return back()->with('info', 'Alamat Toko Berhasil Diperbarui');
    }
}
