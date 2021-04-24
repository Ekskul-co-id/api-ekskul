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
            'image_baner' => env('APP_URL').'/settings/1619276952.jpg'
        ]);
        Setting::create([
            'image_baner' => env('APP_URL').'/settings/1619276967.jpg'
        ]);
        Setting::create([
            'image_baner' => env('APP_URL').'/settings/1619277015.jpg'
        ]);
        Setting::create([
            'image_baner' => env('APP_URL').'/settings/1619277037.jpg'
        ]);
    }
}
