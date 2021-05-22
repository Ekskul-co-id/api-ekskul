<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Video::create([
            'title' => '01 Memegang gitar',
            'video_id' => 'DMI2LgVRHWw',
            'description' => 'Pada video ini kita belajar cara memegang gitar',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '02 Kunci gitar',
            'video_id' => '62mOP9kNz_c',
            'description' => 'Pada video ini kita belajar macam-macam kunci gitar',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '03 Memetik gitar',
            'video_id' => 'oOMBO9i2Lu4',
            'description' => 'Pada video ini kita belajar cara memetik gitar',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '04 Membuat gitar',
            'video_id' => 'sRMoszxlmp4',
            'description' => 'Pada video ini kita belajar cara memetik gitar',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '05 Merusak gitar',
            'video_id' => 'xoHtzrsMduM',
            'description' => 'Pada video ini kita belajar cara memetik gitar',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '06 Memegang gitar',
            'video_id' => 'DMI2LgVRHWw',
            'description' => 'Pada video ini kita belajar cara memegang gitar',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '07 Kunci gitar',
            'video_id' => '62mOP9kNz_c',
            'description' => 'Pada video ini kita belajar macam-macam kunci gitar',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '08 Memetik gitar',
            'video_id' => 'oOMBO9i2Lu4',
            'description' => 'Pada video ini kita belajar cara memetik gitar',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '09 Membuat gitar',
            'video_id' => 'sRMoszxlmp4',
            'description' => 'Pada video ini kita belajar cara memetik gitar',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '10 Merusak gitar',
            'video_id' => 'xoHtzrsMduM',
            'description' => 'Pada video ini kita belajar cara memetik gitar',
            'playlist_id' => '1',
        ]);
        
        Video::create([
            'title' => '01 Aplikasi editing',
            'video_id' => 'DMI2LgVRHWw',
            'description' => 'Pada video ini kita akan berkenalan dengan aplikasi editing yang akan digunakan',
            'playlist_id' => '2',
        ]);
        Video::create([
            'title' => '02 Setup video',
            'video_id' => 'DMI2LgVRHWw',
            'description' => 'Pada video ini kita belajar cara memilih video untuk di edit',
            'playlist_id' => '2',
        ]);
    }
}
