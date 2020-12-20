<?php

namespace App\Http\Controllers\User;

use App\Address;
use App\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Province;

class AddressController extends Controller
{
    public function index()
    {
        return view('user.address.index', [
            'addresses' => auth()->user()->addresses()->orderByDesc('is_main')->get()
        ]);
    }

    public function create()
    {
        return view('user.address.create', [
            'provinces' => Province::all()->pluck('name', 'province_id')
        ]);
    }

    public function cities($id)
    {
        abort_if(!request()->ajax(), 401);

        $city = City::where('province_id', $id)->get();
        return response()->json($city, 200);
    }

    public function store(StoreAddressRequest $request)
    {
        $validated = $request->validated();
        $address = auth()->user()->addresses()->where('is_main', true)->get();

        if ($address && $request->has('is_main')) {
            auth()->user()->addresses()->update(['is_main' => false]);
        }

        $validated['user_id'] = auth()->id();
        $validated['is_main'] = !$address || $request->has('is_main') ? true : false;

        Address::create($validated);
        return back()->with('info', 'Berhasil Menambahkan Alamat Baru');
    }


    public function edit(Address $address)
    {
        $provinces = Province::all()->pluck('name', 'province_id');
        $cities = City::where('province_id', $address->city->province_id)->get()->pluck('name', 'city_id');
        return view('user.address.edit', compact('address', 'provinces', 'cities'));
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());
        return back()->with('info', 'Alamat Anda Berhasil Diperbarui');
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return back()->with('info', 'Berhasil Menghapus Alamat');
    }

    public function setIsMain(Address $address)
    {
        auth()->user()->addresses()->where('is_main', true)->update(['is_main' => false]);

        $address->update(['is_main' => true]);
        return back()->with('info', 'Alamat Utama Berhasil Diperbarui');
    }
}
