<?php

use App\ForumCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Pajale (Padi Jagung Kedelai)',
            'Input & Sarana Pertanian',
            'Sayuran & Buah',
            'Organik',
            'Palawija',
            'Padi',
            'Cabe',
            'Nutrisi',
            'Hama',
            'Traktor'
        ];

        foreach ($categories as $name) {
            ForumCategory::create([
                'name' => $name,
                'slug' => Str::slug($name)
            ]);
        }
    }
}
