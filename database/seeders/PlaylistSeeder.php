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
            'image' => env('APP_URL').'/playlist/1605857358.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara bermain gitar yang benar dari basic nya hingga advance.',
            'price' => '150000',
            'silabus1' => 'example 1',
            'silabus2' => 'example 2',
            'silabus3' => 'example 3',
            'silabus4' => 'example 4',
        ]);
        
        Playlist::create([
            'name' => 'Editing video seperti film-film Hollywood',
            'slug' => 'editing-video-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605858686.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit video yang hasilnya seperti film-film Hollywood.',
            'price' => '200000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        Playlist::create([
            'name' => 'Bermain piano yang benar',
            'slug' => 'bermain-piano-yang-benar',
            'category_id' => 3,
            'image' => env('APP_URL').'/playlist/1605858877.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara bermain piano yang benar dari basic nya hingga advance.',
            'price' => '190000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Editing foto seperti film-film Hollywood',
            'slug' => 'editing-foto-seperti-film-film-hollywood',
            'category_id' => 1,
            'image' => env('APP_URL').'/playlist/1605859173.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit foto yang hasilnya seperti film-film Hollywood.',
            'price' => '230000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        Playlist::create([
            'name' => 'Bermain karet yang benar',
            'slug' => 'bermain-karet-yang-benar',
            'category_id' => 4,
            'image' => env('APP_URL').'/playlist/1605859321.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara bermain karet yang benar dari basic nya hingga advance.',
            'price' => '100000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Editing game seperti film-film Hollywood',
            'slug' => 'editing-game-seperti-film-film-hollywood',
            'category_id' => 1,
            'image' => env('APP_URL').'/playlist/1605859585.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara game video yang hasilnya seperti film-film Hollywood.',
            'price' => '230000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        Playlist::create([
            'name' => 'Bermain bekel yang benar',
            'slug' => 'bermain-bekel-yang-benar',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859599.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara bermain bekel yang benar dari basic nya hingga advance.',
            'price' => '120000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Editing sendal seperti film-film Hollywood',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Dummy 1',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Dummy 2',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        
        Playlist::create([
            'name' => 'Dummy 3',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Dummy 4',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Dummy 5',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Dummy 6',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Dummy 7',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Dummy 8',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Dummy 9',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        
        Playlist::create([
            'name' => 'Dummy 10',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'image' => env('APP_URL').'/playlist/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di playlist ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus1' => 'example',
            'silabus2' => 'example',
            'silabus3' => 'example',
            'silabus4' => 'example',
        ]);
        Rating::factory(150)->create();
    }
}
