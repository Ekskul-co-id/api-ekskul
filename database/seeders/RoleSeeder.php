<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        
        $roleMentor = Role::create(['name' => 'mentor']);
        
        $roleUser = Role::create(['name' => 'user']);
        
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@ekskul.co.id',
            'avatar' => 'https://ui-avatars.com/api/?name=Admin+Ekskul&background=FBBF24&color=ffffff&bold=true&format=png',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'address' => 'Indonesia' 
        ]);
        
        $admin->assignRole($roleAdmin);
        
        $user = User::create([
            'name' => 'John',
            'email' => 'john@example.com',
            'avatar' => 'https://ui-avatars.com/api/?name=John&background=FBBF24&color=ffffff&bold=true&format=png',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'address' => 'Japan' 
        ]);
        
        $user->assignRole($roleUser);
        
        $mentor1 = User::create([
            'name' => 'Angga Maulana, S.Skom',
            'email' => 'angga@maulana.com',
            'avatar' => 'https://ui-avatars.com/api/?name=Angga+Maulana&background=FBBF24&color=ffffff&bold=true&format=png',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'address' => 'Italia' 
        ]);
        
        $mentor1->assignRole($roleMentor);
        
        $mentor2 = User::create([
            'name' => 'M.Fikri',
            'email' => 'fikri@example.com',
            'avatar' => 'https://ui-avatars.com/api/?name=Fikri&background=FBBF24&color=ffffff&bold=true&format=png',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'address' => 'England' 
        ]);
        
        $mentor2->assignRole($roleMentor);
        
        $mentor3 = User::create([
            'name' => 'M.Fauzan W',
            'email' => 'pojan@example.com',
            'avatar' => 'https://ui-avatars.com/api/?name=Fauzan+W&background=FBBF24&color=ffffff&bold=true&format=png',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'address' => 'Japan' 
        ]);
        
        $mentor3->assignRole($roleMentor);
        
        User::factory(35)->create();
    }
}
