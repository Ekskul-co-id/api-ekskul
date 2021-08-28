<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Announcement::create([
            'title' => 'Diskon 10% bor, buruan beli',
            'image' => env('APP_URL').'/announcement/1605859585.png',
            'message' => 'Gas bor course yang ini lagi diskon gede ni 10%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'public'
        ]);
        Announcement::create([
            'title' => 'Diskon 40% buat lo nih',
            'image' => env('APP_URL').'/announcement/1605858877.png',
            'message' => 'Kita punya diskon khusus buat lo nih, beli ini course sekarang diskon 40%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'private',
            'user_id' => 1
        ]);
        Announcement::create([
            'title' => 'Diskon 25% buat lo nih',
            'image' => env('APP_URL').'/announcement/1605858686.png',
            'message' => 'Kita punya diskon khusus buat lo nih, beli ini course sekarang diskon 25%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'private',
            'user_id' => 1
        ]);
        Announcement::create([
            'title' => 'Diskon 80% bor, buruan beli',
            'image' => env('APP_URL').'/announcement/1605857358.png',
            'message' => 'Gas bor course yang ini lagi diskon gede ni 80%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'public'
        ]);
        Announcement::create([
            'title' => 'Diskon 30% bor, buruan beli',
            'image' => env('APP_URL').'/announcement/1605859173.png',
            'message' => 'Kita punya diskon khusus buat lo nih, beli ini course sekarang diskon 30%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'private',
            'user_id' => 2
        ]);
        Announcement::create([
            'title' => 'Diskon 60% buat lo nih',
            'image' => env('APP_URL').'/announcement/1605859321.png',
            'message' => 'Kita punya diskon khusus buat lo nih, beli ini course sekarang diskon 60%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'private',
            'user_id' => 1
        ]);
        Announcement::create([
            'title' => 'Diskon 75% bor, buruan beli',
            'image' => env('APP_URL').'/announcement/1605859585.png',
            'message' => 'Gas bor course yang ini lagi diskon gede ni 75%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'public'
        ]);
        Announcement::create([
            'title' => 'Diskon 45% bor, buruan beli',
            'image' => env('APP_URL').'/announcement/1605859599.png',
            'message' => 'Kita punya diskon khusus buat lo nih, beli ini course sekarang diskon 45%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'private',
            'user_id' => 1,
        ]);
        Announcement::create([
            'title' => 'Diskon 95% bor, buruan beli',
            'image' => env('APP_URL').'/announcement/1605859585.png',
            'message' => 'Gas bor course yang ini lagi diskon gede ni 95%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'public'
        ]);
        Announcement::create([
            'title' => 'Diskon 50% buat lo nih',
            'image' => env('APP_URL').'/announcement/1605859951.png',
            'message' => 'Kita punya diskon khusus buat lo nih, beli ini course sekarang diskon 50%, ayo buruan beli sebelum tanggal 31 Febuari, gass lah selagi promo masih ada jangan disia-siain, buruan beli woy',
            'type' => 'private',
            'user_id' => 2
        ]);
    }
}
