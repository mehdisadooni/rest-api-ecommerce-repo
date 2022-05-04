<?php

namespace Modules\City\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\City\Entities\City;
use Modules\Province\Entities\Province;
use Tests\TestCase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    public function test_city_belongs_to_a_province()
    {
        $city = City::factory()->create();
        $this->assertInstanceOf(Province::class, $city->province);
    }
}
