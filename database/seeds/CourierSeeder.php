<?php

use App\Courier;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Courier::insert(
            [
                ['code' => 'jne', 'name' => 'JNE'],
                ['code' => 'tiki', 'name' => 'TIKI'],
                ['code' => 'pos', 'name' => 'POS Indonesia'],
            ]
        );
    }
}
