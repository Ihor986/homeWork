<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '123456', // password
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'phone' => $this->faker->phoneNumber,
            'role' => $this->faker->randomElement($array = array('employer', 'worker', 'admin')),
            // 'remember_token' => Str::random(10),
        ];
    }
}
