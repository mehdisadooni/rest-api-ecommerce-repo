<?php

namespace Modules\User\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\City\Entities\City;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\User\Entities\User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $city = City::factory()->create();
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'address' => $this->faker->address,
            'cellphone' => $this->faker->unique()->phoneNumber,
            'postal_code' => $this->faker->postcode,
            'province_id' => $city->province_id,
            'city_id' => $city->id,
            'password' => Hash::make('password'),
        ];
    }
}

