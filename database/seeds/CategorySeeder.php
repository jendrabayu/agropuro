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

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'image' => 'images/category/dummy.jpg'
            ]);
        }
    }
}
