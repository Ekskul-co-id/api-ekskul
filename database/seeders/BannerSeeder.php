<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'image_baner' => env('APP_URL').'/settings/1619276952.jpg',
            'sequence' => 1,
        ]);
        Setting::create([
            'image_baner' => env('APP_URL').'/settings/1619276967.jpg',
            'sequence' => 2,
        ]);
        Setting::create([
            'image_baner' => env('APP_URL').'/settings/1619277015.jpg',
            'sequence' => 3,
        ]);
        Setting::create([
            'image_baner' => env('APP_URL').'/settings/1619277037.jpg',
            'sequence' => 4,
        ]);
    }
}
