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
        
        $roleUser = Role::create(['name' => 'user']);
        
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@ekskul.co.id',
            'avatar' => 'https://ui-avatars.com/api/?name=Admin+Ekskul&background=FBBF24&color=ffffff&bold=true&format=png',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'address' => 'Indonesia' 
        ]);
        
        $admin->syncRoles($roleAdmin);
        
        $user = User::create([
            'name' => 'John',
            'email' => 'john@example.com',
            'avatar' => 'https://ui-avatars.com/api/?name=John&background=FBBF24&color=ffffff&bold=true&format=png',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'address' => 'Japan' 
        ]);
        
        $user->syncRoles($roleUser);
        
        User::factory(35)->create();
    }
}
