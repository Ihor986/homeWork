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
        $i = 0;
        $user_id = 1;
        $vacancy_id = 1;
        $newVacancy_id = 2;
        $newUser_id = 2;
        while ($i < 50) {

            DB::table('user_vacancy')->insert([
                'user_id' => $user_id,
                'vacancy_id' => $vacancy_id
            ]);
            DB::table('user_vacancy')->insert([
                'user_id' => $user_id,
                'vacancy_id' => $newVacancy_id
            ]);
            DB::table('user_vacancy')->insert([
                'user_id' => $newUser_id,
                'vacancy_id' => $vacancy_id
            ]);
            DB::table('user_vacancy')->insert([
                'user_id' => $newUser_id,
                'vacancy_id' => $newVacancy_id
            ]);
            $user_id = $user_id + 2;
            $newUser_id = $newUser_id + 2;
            $vacancy_id = $vacancy_id + 2;
            $newVacancy_id = $newVacancy_id + 2;
            $i++;
        }
    }
}
