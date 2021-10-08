<?php

namespace Database\Seeders;

use App\Models\Playlist;
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
            'name' => '01 Memegang gitar',
            'course_id' => 1,
        ]);
        Playlist::create([
            'name' => '02 Kunci gitar',
            'course_id' => 1,
        ]);
        Playlist::create([
            'name' => '03 Memetik gitar',
            'course_id' => 1,
        ]);
        Playlist::create([
            'name' => '04 Membuat gitar',
            'course_id' => 1,
        ]);
        Playlist::create([
            'name' => '05 Merusak gitar',
            'course_id' => 1,
        ]);
        Playlist::create([
            'name' => '01 Beginner step',
            'course_id' => 3,
        ]);
        Playlist::create([
            'name' => '02 Middle step',
            'course_id' => 3,
        ]);
        Playlist::create([
            'name' => '03 Advance step',
            'course_id' => 3,
        ]);
    }
}
