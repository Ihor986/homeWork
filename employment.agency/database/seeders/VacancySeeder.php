<?php

namespace Database\Seeders;

use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vacancy::factory(70)->create(['status' =>  'active']);
        Vacancy::factory(30)->create(['status' =>  'closed', 'workers_amount' => 2, 'workers_booked' => 2]);
    }
}
