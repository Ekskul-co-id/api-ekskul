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
            'youtube_id' => 'DMI2LgVRHWw',
            'duration' => '12',
            'playlist_id' => '1',
        ])->users()->attach([1,2]);
        
        Video::create([
            'title' => '02 Memegang gitar pake kuku',
            'youtube_id' => '62mOP9kNz_c',
            'duration' => '19',
            'playlist_id' => '1',
        ])->users()->attach([1,2]);
        
        Video::create([
            'title' => '03 Memegang gitar gapake apa-apa',
            'youtube_id' => 'oOMBO9i2Lu4',
            'duration' => '16',
            'playlist_id' => '1',
        ])->users()->attach([1,2]);
        
        Video::create([
            'title' => '04 Kunci gitar dengan obeng',
            'youtube_id' => 'sRMoszxlmp4',
            'duration' => '22',
            'playlist_id' => '2',
        ])->users()->attach([1,2]);
        
        Video::create([
            'title' => '05 Kunci gitar dengan tang',
            'youtube_id' => 'xoHtzrsMduM',
            'duration' => '9',
            'playlist_id' => '2',
        ])->users()->attach([1]);
        
        Video::create([
            'title' => '06 Kunci gitar dengan gembok',
            'youtube_id' => 'DMI2LgVRHWw',
            'duration' => '16',
            'playlist_id' => '2',
        ])->users()->attach([1]);
        
        Video::create([
            'title' => '07 Kunci gitar dengan pinset',
            'youtube_id' => '62mOP9kNz_c',
            'duration' => '18',
            'playlist_id' => '2',
        ])->users()->attach([1,2]);
        
        Video::create([
            'title' => '08 Memetik gitar kuku',
            'youtube_id' => 'oOMBO9i2Lu4',
            'duration' => '28',
            'playlist_id' => '3',
        ])->users()->attach([2]);
        
        Video::create([
            'title' => '09 Memtik gitar dengan kaki',
            'youtube_id' => 'sRMoszxlmp4',
            'duration' => '17',
            'playlist_id' => '3',
        ]);
        
        Video::create([
            'title' => '10 Membuat gitar dengan semen',
            'youtube_id' => 'xoHtzrsMduM',
            'duration' => '10',
            'playlist_id' => '4',
        ]);
        
        Video::create([
            'title' => '11 Membuat gitar dengan kayu',
            'youtube_id' => 'DMI2LgVRHWw',
            'duration' => '21',
            'playlist_id' => '4',
        ]);
        
        Video::create([
            'title' => '12 Menghancurkan gitar dengan kepala',
            'youtube_id' => 'DMI2LgVRHWw',
            'duration' => '7',
            'playlist_id' => '5',
        ]);
    }
}
