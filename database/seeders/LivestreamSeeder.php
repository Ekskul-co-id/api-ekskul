<?php

namespace Database\Seeders;

use App\Models\Livestream;
use Illuminate\Database\Seeder;

class LivestreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $silabus = ["Example 1","Example 2","Example 3","Example 4","Example 5"];
        
        Livestream::create([
            'title' => '[DS3] NEKOmorphs!! nya',
            'image' => 'https://i.ytimg.com/vi/YhmEqefSZZc/mqdefault.jpg',
            'youtube_id' => 'YhmEqefSZZc',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 4,
            'price' => '80000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-05 12:00',
            'end_date' => null,
        ]);
        
        Livestream::create([
            'title' => 'TACO BELL: THE STREAM',
            'image' => 'https://i.ytimg.com/vi/zuIDDWQlUWg/mqdefault.jpg',
            'youtube_id' => 'zuIDDWQlUWg',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 4,
            'price' => '65000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-07 07:00',
            'end_date' => null,
        ]);
        
        Livestream::create([
            'title' => '[BUS SIMULATOR] All aboard Goomba\'s bussin Big Rig !',
            'image' => 'https://i.ytimg.com/vi/Ds71TFQCr5c/mqdefault.jpg',
            'youtube_id' => 'Ds71TFQCr5c',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 4,
            'price' => '740000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-09 15:00',
            'end_date' => null,
        ]);
        
        Livestream::create([
            'title' => '[INSIDE] inside what??',
            'image' => 'https://i.ytimg.com/vi/jPJSTCAgyjE/mqdefault.jpg',
            'youtube_id' => 'jPJSTCAgyjE',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 7,
            'price' => '120000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-10 12:00',
            'end_date' => null,
        ]);
        
        Livestream::create([
            'title' => '[MINECRAFT] We bully the Enderdragon #HololiveEN',
            'image' => 'https://i.ytimg.com/vi/JGyaMXShc4g/mqdefault.jpg',
            'youtube_id' => 'JGyaMXShc4g',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 7,
            'price' => '90000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-07 20:00',
            'end_date' => null,
        ]);
        
        Livestream::create([
            'title' => '[JUMP KING] TACTICAL LEAP',
            'image' => 'https://i.ytimg.com/vi/vci-RuRSios/mqdefault.jpg',
            'youtube_id' => 'vci-RuRSios',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 7,
            'price' => '85000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-05 22:00',
            'end_date' => null,
        ]);
        
        Livestream::create([
            'title' => '[One Hand Clapping] cl a p',
            'image' => 'https://i.ytimg.com/vi/4pmBp7C3C1E/mqdefault.jpg',
            'youtube_id' => '4pmBp7C3C1E',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 7,
            'price' => '100000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-07 09:00',
            'end_date' => null,
        ]);
        
        Livestream::create([
            'title' => '[ASSETTO CORSA] SHARK DORIFTO',
            'image' => 'https://i.ytimg.com/vi/_vldG5PtM44/mqdefault.jpg',
            'youtube_id' => '_vldG5PtM44',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 5,
            'price' => '25000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-11 18:00',
            'end_date' => null,
        ]);
    }
}
