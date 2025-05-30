<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => Role::where('code', 'admin')->first()->id,
            'first_name' => 'John',
            'middle_name' => 'D',
            'last_name' => 'Doe',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => Role::where('code', 'user')->first()->id,
            'first_name' => 'Pedro',
            'middle_name' => 'P',
            'last_name' => 'Penduco',
            'username' => 'ppenduco',
            'email' => 'ppenduco@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->count(30)->create();
    }
}
