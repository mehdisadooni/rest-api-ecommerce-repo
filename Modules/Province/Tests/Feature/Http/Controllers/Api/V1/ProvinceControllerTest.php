<?php

namespace Modules\Province\Tests\Feature\Http\Controllers\Api\V1;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Province\Entities\Province;
use Tests\TestCase;

class ProvinceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_provinces_use_pagination()
    {
        $province = Province::factory()->create();

        $response = $this->getJson(route('provinces.index'))->assertOk()->json();

        $this->assertEquals(1, count($response['provinces']));
        $this->assertEquals($province->name, $response['provinces'][0]['name']);
        $this->assertArrayHasKey('provinces', $response);
    }

    public function test_fetch_single_province()
    {
        $province = Province::factory()->create();

        $response = $this->getJson(route('provinces.show', ['province' => $province->id]))->assertOk()->json();

        $this->assertEquals($province->name, $response['province']['name']);
    }

    public function test_store_new_province()
    {
        $province = Province::factory()->raw();

        $response = $this->postJson(route('provinces.store'), $province)->assertCreated()->json();

        $this->assertEquals($province['name'], $response['province']['name']);
        $this->assertDatabaseHas('provinces', ['name' => $response['province']['name']]);
    }

    public function test_while_storing_province_name_field_is_required()
    {
        $this->withExceptionHandling()
            ->postJson(route('provinces.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_update_province()
    {
        $province = Province::factory()->create();
        $newProvince = Province::factory()->raw();

        $response = $this->putJson(route('provinces.update', ['province' => $province->id]), $newProvince)
            ->assertOk()->json();

        $this->assertEquals($newProvince['name'], $response['province']['name']);
        $this->assertDatabaseHas('provinces', ['id' => $province->id, 'name' => $newProvince['name']]);
    }

    public function test_while_updating_category_field_is_required()
    {
        $province = Province::factory()->create();

        $this->withExceptionHandling()
            ->putJson(route('provinces.update', $province->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_soft_delete_province()
    {
        $province = Province::factory()->create();

        $this->deleteJson(route('provinces.destroy', $province->id))->assertOk()->json();

        $this->assertSoftDeleted('provinces', ['id' => $province->id]);
    }
}
