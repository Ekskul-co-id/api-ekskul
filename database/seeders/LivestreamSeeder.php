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
        $silabus = ['Example 1', 'Example 2', 'Example 3', 'Example 4', 'Example 5'];

        Livestream::create([
            'title' => '[DS3] NEKOmorphs!! nya',
            'slug' => 'ds3-nekomorphs-nya',
            'category_id' => 2,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfaHH3kd9ClTYZTLA6VXnUEwzTHzssfZDlpA&usqp=CAU',
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
            'slug' => 'taco-bell-the-stream',
            'category_id' => 1,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfyKzoHCHpG-sKaoRmx7PxyyQedyEhs-m1_Q&usqp=CAU',
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
            'slug' => 'bus-simulator-all-aboard-goombas-bussin-big-rig',
            'category_id' => 4,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSV5XZMs7hau3pSfFQNaecAfcsnAri-HiR1Ow&usqp=CAU',
            'youtube_id' => 'Ds71TFQCr5c',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 4,
            'price' => '0',
            'is_paid' => false,
            'silabus' => $silabus,
            'start_date' => '2021-08-09 15:00',
            'end_date' => null,
        ]);

        Livestream::create([
            'title' => '[INSIDE] inside what??',
            'slug' => 'inside-inside-what',
            'category_id' => 3,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcQ4XxjbdrRGy22p-0YExMf5ZIQcFlgCIaBg&usqp=CAU',
            'youtube_id' => 'jPJSTCAgyjE',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 3,
            'price' => '120000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-10 12:00',
            'end_date' => null,
        ]);

        Livestream::create([
            'title' => '[MINECRAFT] We bully the Enderdragon #HololiveEN',
            'slug' => 'minecraft-we-bully-the-enderdragon-hololiveen',
            'category_id' => 2,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_DvJAMG6KO0KaE7FJvsdnpCS3bfG2CKUBrQ&usqp=CAU',
            'youtube_id' => 'JGyaMXShc4g',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 3,
            'price' => '90000',
            'is_paid' => true,
            'silabus' => $silabus,
            'start_date' => '2021-08-07 20:00',
            'end_date' => null,
        ]);

        Livestream::create([
            'title' => '[JUMP KING] TACTICAL LEAP',
            'slug' => 'jump-king-tactical-leap',
            'category_id' => 4,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeNheqcIALnMVV78JaPgm0R6kDS3AV0uWwrg&usqp=CAU',
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
            'slug' => 'one-hand-clapping-cl-a-p',
            'category_id' => 2,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqQ2hRAf3NJBYzuW0izAO1vQopFV40o7NrtA&usqp=CAU',
            'youtube_id' => '4pmBp7C3C1E',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam libero sit amet felis vehicula, at maximus nibh tincidunt. Fusce scelerisque velit eu risus mattis, in mattis massa ultricies. Donec posuere nunc congue lacinia dignissim. Mauris nec lacus eget sem hendrerit faucibus. Sed consectetur, diam id consequat pharetra, nisi diam efficitur est, ac malesuada risus nibh vitae turpis. Sed quis leo consectetur, congue metus quis, scelerisque risus. Curabitur nunc dui, mollis sed vehicula sit amet, porta eleifend diam. Aenean condimentum metus vitae aliquet egestas. Aenean vitae consequat ex, eu tempus orci. Phasellus finibus ante eget nisl finibus, vel euismod turpis ultricies. Curabitur sed sollicitudin libero, at viverra nisi.',
            'user_id' => 5,
            'price' => '0',
            'is_paid' => false,
            'silabus' => $silabus,
            'start_date' => '2021-08-07 09:00',
            'end_date' => null,
        ]);

        Livestream::create([
            'title' => '[ASSETTO CORSA] SHARK DORIFTO',
            'slug' => 'assetto-corsa-shark-dorifto',
            'category_id' => 1,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTW18y2QQ4jx2kX628VwmVtlKK0kx1JFz37lA&usqp=CAU',
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
