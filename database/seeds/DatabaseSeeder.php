<?php

use App\ForumCategory;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CourierSeeder::class,
            BankAccountSeeder::class,
            LocationSeeder::class,
            ShopAddressSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderStatusSeeder::class,
            ForumCategorySeeder::class,
            ForumSeeder::class
        ]);
    }
}
