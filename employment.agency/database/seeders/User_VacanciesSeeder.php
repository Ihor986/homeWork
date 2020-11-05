<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class User_VacanciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_vacancy')->insert([
            'user_id' => 2,
            'vacancy_id' => 2
        ]);
    }
}
