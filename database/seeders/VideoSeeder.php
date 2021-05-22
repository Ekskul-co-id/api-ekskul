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
            'title' => '01 Memegang gitar pake jari',
            'video_id' => 'DMI2LgVRHWw',
            'duration' => '12',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '02 Memegang gitar pake kuku',
            'video_id' => '62mOP9kNz_c',
            'duration' => '19',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '03 Memegang gitar gapake apa-apa',
            'video_id' => 'oOMBO9i2Lu4',
            'duration' => '16',
            'playlist_id' => '1',
        ]);
        Video::create([
            'title' => '04 Kunci gitar dengan obeng',
            'video_id' => 'sRMoszxlmp4',
            'duration' => '22',
            'playlist_id' => '2',
        ]);
        Video::create([
            'title' => '05 Kunci gitar dengan tang',
            'video_id' => 'xoHtzrsMduM',
            'duration' => '9',
            'playlist_id' => '2',
        ]);
        Video::create([
            'title' => '06 Kunci gitar dengan gembok',
            'video_id' => 'DMI2LgVRHWw',
            'duration' => '16',
            'playlist_id' => '2',
        ]);
        Video::create([
            'title' => '07 Kunci gitar dengan pinset',
            'video_id' => '62mOP9kNz_c',
            'duration' => '18',
            'playlist_id' => '2',
        ]);
        Video::create([
            'title' => '08 Memetik gitar kuku',
            'video_id' => 'oOMBO9i2Lu4',
            'duration' => '28',
            'playlist_id' => '3',
        ]);
        Video::create([
            'title' => '09 Memtik gitar dengan kaki',
            'video_id' => 'sRMoszxlmp4',
            'duration' => '17',
            'playlist_id' => '3',
        ]);
        Video::create([
            'title' => '10 Membuat gitar dengan semen',
            'video_id' => 'xoHtzrsMduM',
            'duration' => '10',
            'playlist_id' => '4',
        ]);
        
        Video::create([
            'title' => '11 Membuat gitar dengan kayu',
            'video_id' => 'DMI2LgVRHWw',
            'duration' => '21',
            'playlist_id' => '4',
        ]);
        Video::create([
            'title' => '12 Menghancurkan gitar dengan kepala',
            'video_id' => 'DMI2LgVRHWw',
            'duration' => '7',
            'playlist_id' => '5',
        ]);
    }
}
