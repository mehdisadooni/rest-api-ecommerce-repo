<?php

namespace Modules\City\Tests\Feature\Http\Controllers\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\City\Entities\City;
use Modules\Province\Entities\Province;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_fetch_cities_use_pagination()
    {
        $city = City::factory()->create();

        $response = $this->getJson(route('cities.index'))->assertOk()->json();

        $this->assertEquals(1, count($response['cities']));
        $this->assertEquals($city->name, $response['cities'][0]['name']);
        $this->assertArrayHasKey('cities', $response);
    }

    public function test_fetch_single_city()
    {
        $city = City::factory()->create();

        $response = $this->getJson(route('cities.show', ['city' => $city->id]))->assertOk()->json();

        $this->assertEquals($city->name, $response['city']['name']);
    }

    public function test_store_new_city()
    {
        $province = Province::factory()->create();
        $city = Province::factory()->raw();
        $city['province_id'] = $province->id;

        $response = $this->postJson(route('cities.store'), $city)->assertCreated()->json();
        $this->assertEquals($city['name'], $response['city']['name']);
        $this->assertEquals($city['province_id'], $response['city']['province_id']);
        $this->assertDatabaseHas('cities', ['name' => $response['city']['name']]);
    }

    public function test_while_storing_category_name_field_is_required()
    {
        $province = Province::factory()->create();
        $this->withExceptionHandling()
            ->postJson(route('cities.store'), ['province_id' => $province->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_while_storing_category_province_id_field_is_required()
    {
        $city = Province::factory()->raw();
        $this->withExceptionHandling()
            ->postJson(route('cities.store'), $city)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('province_id');
    }

    public function test_update_brand()
    {
        $city = City::factory()->create();
        $newCity = City::factory()->raw();

        $response = $this->patchJson(route('cities.update', $city->id), [
            'name' => $newCity['name']
        ])->assertOk()->json();

        $this->assertEquals($newCity['name'], $response['city']['name']);
        $this->assertDatabaseHas('cities', ['id' => $city->id, 'name' => $newCity['name']]);
    }

    public function test_while_updating_city_name_field_is_required()
    {
        $city = City::factory()->create();
        $this->withExceptionHandling()
            ->putJson(route('cities.update', ['city' => $city->id]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_soft_delete_city()
    {
        $city = City::factory()->create();

        $this->deleteJson(route('cities.destroy', $city->id))->assertOk()->json();

        $this->assertSoftDeleted('cities', ['id' => $city->id]);
    }
}
