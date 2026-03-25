<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Prueba::factory(5)->create();
        
        User::factory()->create([
            'name' => 'angel',
            'email' => 'angelomarsanz@gmail.com',
            'password' => 'Angel2703$laravel'
        ]);
        
    }
}
