<?php

namespace Database\Seeders;

use App\Models\Playlist;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Playlist::create([
            'name' => 'Bermain gitar yang benar',
            'slug' => 'bermain-gitar-yang-benar',
            'category_id' => 3,
            'image' => 'playlist/1605857358.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara bermain gitar yang benar dari basic nya hingga advance.',
            'price' => '150000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Editing video seperti film-film Hollywood',
            'slug' => 'editing-video-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => 'playlist/1605858686.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit video yang hasilnya seperti film-film Hollywood.',
            'price' => '200000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Rating::factory(20)->create();
    }
}
