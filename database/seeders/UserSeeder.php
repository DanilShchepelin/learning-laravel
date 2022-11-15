<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::factory()->create([
            'name' => 'Author',
            'email' => 'author@author.com',
            'role' => Roles::Author->getName(),
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => Roles::Admin->getName(),
        ]);
    }
}
