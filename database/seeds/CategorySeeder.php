<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Pupuk Organik',
            'Pupuk Kimia',
            'Pupuk Buah',
            'Pupuk Organik Cair',
            'Pupuk Kimia Cair'
        ];

        foreach ($categories as $item) {
            Category::create([
                'name' => $item,
                'slug' => Str::slug($item),
                'image' => 'images/category/dummy.jpg'
            ]);
        }
    }
}
