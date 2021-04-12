<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Bahasa',
            'slug' => 'bahasa',
            'icon' => 'icon/bahasa.png'
        ]);
        Category::create([
            'name' => 'Multimedia',
            'slug' => 'multimedia',
            'icon' => 'icon/multimedia.png'
        ]);
        Category::create([
            'name' => 'Musik',
            'slug' => 'musik',
            'icon' => 'icon/musik.png'
        ]);
        Category::create([
            'name' => 'Teknik',
            'slug' => 'teknik',
            'icon' => 'icon/teknik.png'
        ]);
    }
}
