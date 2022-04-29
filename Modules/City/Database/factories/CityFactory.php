<?php

namespace Modules\City\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Province\Entities\Province;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\City\Entities\City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'province_id' => Province::factory()->create()->id
        ];
    }
}

