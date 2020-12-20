<?php

use App\ShopAddress;
use Illuminate\Database\Seeder;

class ShopAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShopAddress::create([
            'city_id' => 160,
            'kecamatan' => 'Sumbersari',
            'kelurahan' => 'Sumbersari',
            'phone_number' => '0331326911',
            'detail' => 'Jl. Kalimantan No.37, Krajan Timur'
        ]);
    }
}
