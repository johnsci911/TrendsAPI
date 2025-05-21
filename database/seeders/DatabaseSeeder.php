<?php

namespace Database\Seeders;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'johnkarlo.315@gmail.com',
            'name' => 'John Karlo',
            'username' => 'johnkarlo'
        ]);

        Tweet::factory(100)->create();
    }
}
