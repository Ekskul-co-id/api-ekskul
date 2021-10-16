<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Voucher::create([
            'code' => 'ESKL111111',
            'discount' => 10000,
            'limit_type' => 'time',
            'voucher_type' => 'public',
            'limit_time' => Carbon::now()->subDays(5),
        ]);

        Voucher::create([
            'code' => 'ESKL222222',
            'discount' => 15000,
            'limit_type' => 'time',
            'voucher_type' => 'private',
            'limit_time' => Carbon::now()->subDays(2),
            'user_id' => 1,
        ]);

        Voucher::create([
            'code' => 'ESKL212121',
            'discount' => 18000,
            'limit_type' => 'time',
            'voucher_type' => 'private',
            'limit_time' => Carbon::now()->subDays(3),
            'user_id' => 2,
        ]);

        Voucher::create([
            'code' => 'ESKL333333',
            'discount' => 25000,
            'limit_type' => 'time',
            'voucher_type' => 'public',
            'limit_time' => Carbon::now()->addDays(5),
        ]);

        Voucher::create([
            'code' => 'ESKL444444',
            'discount' => 25000,
            'limit_type' => 'time',
            'voucher_type' => 'public',
            'limit_time' => Carbon::now()->addDays(7),
            'user_id' => 1,
        ]);

        Voucher::create([
            'code' => 'ESKL414141',
            'discount' => 21000,
            'limit_type' => 'time',
            'voucher_type' => 'public',
            'limit_time' => Carbon::now()->addDays(13),
            'user_id' => 2,
        ]);

        Voucher::create([
            'code' => 'ESKL555555',
            'discount' => 32000,
            'limit_type' => 'used',
            'voucher_type' => 'public',
            'limit_used' => 1,
        ]);

        Voucher::create([
            'code' => 'ESKL666666',
            'discount' => 35000,
            'limit_type' => 'used',
            'voucher_type' => 'public',
            'limit_used' => 10,
        ]);

        Voucher::create([
            'code' => 'ESKL777777',
            'discount' => 20000,
            'limit_type' => 'life_time',
            'voucher_type' => 'public',
        ]);

        Voucher::create([
            'code' => 'ESKL888888',
            'discount' => 38000,
            'limit_type' => 'life_time',
            'voucher_type' => 'private',
            'user_id' => 1,
        ]);

        Voucher::create([
            'code' => 'ESKL888888',
            'discount' => 42000,
            'limit_type' => 'life_time',
            'voucher_type' => 'private',
            'user_id' => 2,
        ]);
    }
}
