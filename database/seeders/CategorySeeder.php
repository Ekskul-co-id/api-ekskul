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
            'icon' => env('APP_URL').'/icon/bahasa.png'
        ]);
        Category::create([
            'name' => 'Multimedia',
            'slug' => 'multimedia',
            'icon' => env('APP_URL').'/icon/multimedia.png'
        ]);
        Category::create([
            'name' => 'Musik',
            'slug' => 'musik',
            'icon' => env('APP_URL').'/icon/musik.png'
        ]);
        Category::create([
            'name' => 'Teknik',
            'slug' => 'teknik',
            'icon' => env('APP_URL').'/icon/teknik.png'
        ]);
    }
}
