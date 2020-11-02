<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(['email' => 'admin@localhost', 'password' => '123456', 'role' => 'admin']);
        User::factory(50)->create(['role' => 'worker']);
        User::factory(49)->create(['role' => 'employer']);
    }
}
