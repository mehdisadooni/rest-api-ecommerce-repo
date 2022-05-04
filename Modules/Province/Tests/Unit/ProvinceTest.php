<?php

namespace Modules\Province\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Modules\City\Entities\City;
use Tests\TestCase;

class ProvinceTest extends TestCase
{
    use RefreshDatabase;


    public function test_a_province_can_has_many_cities()
    {
        $city = City::factory()->create();
        $province = $city->province;
        $this->assertInstanceOf(Collection::class, $province->cities);
        $this->assertInstanceOf(City::class, $province->cities->first());
    }

    public function test_if_province_is_force_deleted_then_all_its_cities_will_be_force_deleted()
    {
        $city = City::factory()->create();
        $province = $city->province;

        //create another province and city
        $anotherCity = City::factory()->create();
//        delete province
        $province->forceDelete();
        $this->assertDatabaseMissing('provinces', ['id' => $province->id]);
        $this->assertDatabaseMissing('cities', ['id' => $city->id]);
        $this->assertDatabaseHas('cities', ['id' => $anotherCity->id]);
    }
}
