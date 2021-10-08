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
        ])->users()->attach([1, 2]);

        Video::create([
            'title' => '02 Memegang gitar pake kuku',
            'youtube_id' => '62mOP9kNz_c',
            'duration' => '19',
            'playlist_id' => '1',
        ])->users()->attach([1, 2]);

        Video::create([
            'title' => '03 Memegang gitar gapake apa-apa',
            'youtube_id' => 'oOMBO9i2Lu4',
            'duration' => '16',
            'playlist_id' => '1',
        ])->users()->attach([1, 2]);

        Video::create([
            'title' => '04 Kunci gitar dengan obeng',
            'youtube_id' => 'sRMoszxlmp4',
            'duration' => '22',
            'playlist_id' => '2',
        ])->users()->attach([1, 2]);

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
        ])->users()->attach([1, 2]);

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

        Video::create([
            'title' => '01 - Pengenalan RDBMS',
            'youtube_id' => 'WgABoubjQdY',
            'duration' => '10',
            'playlist_id' => '6',
        ]);
        Video::create([
            'title' => '02 - Setup Development Environment',
            'youtube_id' => 'mLC3DBBboTk',
            'duration' => '10',
            'playlist_id' => '6',
        ]);
        Video::create([
            'title' => '03 - Select Statement & Alias dengan PostgreSQL',
            'youtube_id' => 'Ws8ZVcer0Kw',
            'duration' => '18',
            'playlist_id' => '6',
        ]);
        Video::create([
            'title' => '04 - Operasi Aritmatika di PostgreSQL',
            'youtube_id' => 'ytKK6l698Wk',
            'duration' => '17',
            'playlist_id' => '6',
        ]);
        Video::create([
            'title' => '05 - Keyword Distinct di Postgresql',
            'youtube_id' => 'rozZnQkBETg',
            'duration' => '8',
            'playlist_id' => '6',
        ]);
        Video::create([
            'title' => '06 - Null and Empty String Handler',
            'youtube_id' => 'idlj5ox2cvU',
            'duration' => '6',
            'playlist_id' => '7',
        ]);
        Video::create([
            'title' => '07 - Filter data di PostgreSQL',
            'youtube_id' => '4PR_UBKpooU',
            'duration' => '24',
            'playlist_id' => '7',
        ]);
        Video::create([
            'title' => '08 - Operator for Filter data dengan where clause di PostgreSQL',
            'youtube_id' => '7MLBNM576gA',
            'duration' => '13',
            'playlist_id' => '7',
        ]);
        Video::create([
            'title' => '09 - Order data di PostgreSQL',
            'youtube_id' => 'QE2zTT9X4Gk',
            'duration' => '7',
            'playlist_id' => '7',
        ]);
        Video::create([
            'title' => '10 - Limit & Offset di PostgreSQL',
            'youtube_id' => '2vHlPb47eUA',
            'duration' => '7',
            'playlist_id' => '7',
        ]);
        Video::create([
            'title' => '11 - Time is your Practice Part 1',
            'youtube_id' => 'e027zp1nCdM',
            'duration' => '21',
            'playlist_id' => '8',
        ]);
        Video::create([
            'title' => '12 - Single Row Function',
            'youtube_id' => 'Y7ASnS5bX8',
            'duration' => '11',
            'playlist_id' => '8',
        ]);
        Video::create([
            'title' => '13 - Aggregation',
            'youtube_id' => 'z5mIVHXBEeE',
            'duration' => '13',
            'playlist_id' => '8',
        ]);
        Video::create([
            'title' => '14 - Aggregate function with group by',
            'youtube_id' => '2xUzXkLf_fA',
            'duration' => '6',
            'playlist_id' => '8',
        ]);
        Video::create([
            'title' => '15 - Group Function / Aggregation dengan Filter data menggunakan clause Having',
            'youtube_id' => 'jf6O6g0MaZc',
            'duration' => '9',
            'playlist_id' => '8',
        ]);
    }
}
