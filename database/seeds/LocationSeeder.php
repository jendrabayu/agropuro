<?php

use App\City;
use App\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apiKey = env('API_KEY_RAJA_ONGKIR', '206cc2aef17ad58f99012341e0759692');
        $apiUrl = env('API_URL_RAJA_ONGKIR', 'https://api.rajaongkir.com/starter');

        $provinces = Http::withHeaders([
            'Key' => $apiKey
        ])->get($apiUrl . '/province');


        foreach ($provinces['rajaongkir']['results'] as $province) {
            Province::create([
                'province_id' => $province['province_id'],
                'name' => $province['province']
            ]);

            $cities = Http::withHeaders([
                'Key' => $apiKey
            ])->get($apiUrl . '/city?province=' . $province['province_id']);

            foreach ($cities['rajaongkir']['results'] as $city) {
                City::create([
                    'province_id' => $city['province_id'],
                    'city_id' => $city['city_id'],
                    'name' => $city['city_name']
                ]);
            }
        }
    }
}
