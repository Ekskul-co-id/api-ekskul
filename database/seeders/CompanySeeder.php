<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::create([
            'name' => 'Ekskul.co.id',
            'slug' => 'ekskul-co-id',
            'avatar' => 'https://ui-avatars.com/api/?name=Ekskul.co.id&background=FBBF24&color=ffffff&bold=true&format=png',
            'user_id' => 1,
        ]);
        
        $company->users()->attach([
            1 => ['role' => 'owner'],
            3 => ['role' => 'admin'],
            4 => ['role' => 'member'],
            13 => ['role' => 'member'],
            14 => ['role' => 'member'],
            15 => ['role' => 'member'],
            16 => ['role' => 'member'],
            17 => ['role' => 'member'],
        ]);
        
        $company2 = Company::create([
            'name' => 'IndoSec',
            'slug' => 'indosec',
            'avatar' => 'https://ui-avatars.com/api/?name=IndoSec&background=FBBF24&color=ffffff&bold=true&format=png',
            'user_id' => 6,
        ]);
        
        $company2->users()->attach([
            6 => ['role' => 'owner'],
            7 => ['role' => 'admin'],
            8 => ['role' => 'member'],
            18 => ['role' => 'member'],
            19 => ['role' => 'member'],
            20 => ['role' => 'member'],
        ]);
        
        $company3 = Company::create([
            'name' => 'Company 3',
            'slug' => 'company-3',
            'avatar' => 'https://ui-avatars.com/api/?name=Company+3&background=FBBF24&color=ffffff&bold=true&format=png',
            'user_id' => 9,
        ]);
        
        $company3->users()->attach([
            9 => ['role' => 'owner'],
        ]);
        
        $company4 = Company::create([
            'name' => 'Company 4',
            'slug' => 'company-4',
            'avatar' => 'https://ui-avatars.com/api/?name=Company+4&background=FBBF24&color=ffffff&bold=true&format=png',
            'user_id' => 10,
        ]);
        
        $company4->users()->attach([
            10 => ['role' => 'owner'],
        ]);
        
        $company5 = Company::create([
            'name' => 'Company 5',
            'slug' => 'company-5',
            'avatar' => 'https://ui-avatars.com/api/?name=Company+5&background=FBBF24&color=ffffff&bold=true&format=png',
            'user_id' => 11,
        ]);
        
        $company5->users()->attach([
            11 => ['role' => 'owner'],
        ]);
        
        $company6 = Company::create([
            'name' => 'Company 6',
            'slug' => 'company-6',
            'avatar' => 'https://ui-avatars.com/api/?name=Company+6&background=FBBF24&color=ffffff&bold=true&format=png',
            'user_id' => 12,
        ]);
        
        $company6->users()->attach([
            12 => ['role' => 'owner'],
        ]);
    }
}
