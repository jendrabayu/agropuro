<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/**
 * @see https://github.com/mbezhanov/faker-provider-collection#bezhanovfakerprovideravatar
 */

$factory->define(Product::class, function (Faker $faker) {
    $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
    $name = $faker->name;
    return [
        'category_id' => function () {
            return Category::inRandomOrder()->first()->id;
        },
        'nama' => Str::title($name),
        'slug' => Str::slug($name),
        'deskripsi_singkat' => $faker->sentence(30, true),
        'deskripsi' => $faker->paragraph,
        'gambar' => 'images/product/dummy.jpg',
        'stok' => $faker->randomNumber(3),
        'harga' =>  $faker->randomElement([5000, 6000, 7000, 8000, 9000, 10000, 20000, 35000, 50000, 100000, 150000]),
        'berat' => $faker->numberBetween(1, 10) * 1000,
        'diarsipkan' => $faker->boolean(30),
    ];
});
