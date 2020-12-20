<?php

use App\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::insert(
            [
                [
                    'code' => 'belum-bayar',
                    'status_admin' => 'Belum Bayar',
                    'status_user' => 'Belum Bayar',
                    'color' => 'warning'
                ],
                [
                    'code' => 'perlu-dicek',
                    'status_admin' => 'Perlu Dicek',
                    'status_user' => 'Sedang Dicek',
                    'color' => 'light'
                ],
                [
                    'code' => 'perlu-dikirim',
                    'status_admin' => 'Perlu Dikirim',
                    'status_user' => 'Dikemas',
                    'color' => 'info'
                ],
                [
                    'code' => 'dikirim',
                    'status_admin' =>
                    'Dikirim',
                    'status_user' => 'Dikirim',
                    'color' => 'primary'
                ],
                [
                    'code' => 'selesai',
                    'status_admin' => 'Selesai',
                    'status_user' => 'Selesai',
                    'color' => 'success'
                ],
                [
                    'code' => 'dibatalkan',
                    'status_admin' => 'Dibatalkan',
                    'status_user' => 'Dibatalkan',
                    'color' => 'danger'
                ],
            ]
        );
    }
}
