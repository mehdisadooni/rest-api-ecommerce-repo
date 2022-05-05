<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\Category;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Product\Entities\Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'brand_id' => Brand::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'primary_image' => UploadedFile::fake()->image('primary_image.png'),
            'price' => $this->faker->randomNumber(),
            'quantity' => 10,
            'delivery_amount' => $this->faker->randomNumber(),
            'description' => $this->faker->text,
        ];
    }
}

