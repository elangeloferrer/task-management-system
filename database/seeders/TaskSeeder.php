<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role_id', 2)->get();
        $user = User::where('id', 2)->first();


        for ($i = 1; $i <= 7; $i++) {
            Task::factory()->create([
                'order' => $i,
                'user_id' => $user->id
            ]);
        }

        for ($i = 1; $i <= 25; $i++) {
            Task::factory()->create([
                'order' => $i,
                'user_id' => $users->random()->id
            ]);
        }
    }
}
