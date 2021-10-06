<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(PlaylistSeeder::class);
        $this->call(VideoSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(LivestreamSeeder::class);
    }
}
