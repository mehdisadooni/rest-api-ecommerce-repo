<?php

namespace Modules\Brand\Tests\Feature\Http\Controllers\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Brand\Entities\Brand;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_brands_use_pagination()
    {
        $brand = Brand::factory()->create();

        $response = $this->getJson(route('brands.index'))->assertOk()->json();

        $this->assertEquals(1, count($response['brands']));
        $this->assertEquals($brand->name, $response['brands'][0]['name']);
        $this->assertArrayHasKey('brands', $response);
    }

    public function test_fetch_single_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->getJson(route('brands.show', ['brand' => $brand->id]))->assertOk()->json();

        $this->assertEquals($brand->name, $response['brand']['name']);
    }

    public function test_store_new_brand()
    {
        $brand = Brand::factory()->raw();

        $response = $this->postJson(route('brands.store'), $brand)->assertCreated()->json();
        $this->assertEquals($brand['name'], $response['brand']['name']);
        $this->assertDatabaseHas('brands', ['name' => $response['brand']['name']]);
    }

    public function test_while_storing_brand_name_field_is_required()
    {
        $brand = Brand::factory()->raw();
        $this->withExceptionHandling()
            ->postJson(route('brands.store'), [
                'display_name' => $brand['display_name']
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_while_storing_brand_display_name_field_is_required()
    {
        $brand = Brand::factory()->raw();
        $this->withExceptionHandling()
            ->postJson(route('brands.store'), [
                'name' => $brand['name']
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('display_name');
    }


    public function test_update_brand()
    {
        $brand = Brand::factory()->create();
        $newBrand = Brand::factory()->raw();

        $response = $this->patchJson(route('brands.update', $brand->id), [
            'name' => $newBrand['name']
        ])->assertOk()->json();

        $this->assertEquals($newBrand['name'], $response['brand']['name']);
        $this->assertDatabaseHas('brands', ['id' => $brand->id, 'name' => $newBrand['name']]);
    }

    public function test_while_updating_brand_name_field_is_required()
    {
        $brand = Brand::factory()->create();
        $newBrand = Brand::factory()->raw();
        $this->withExceptionHandling()
            ->putJson(route('brands.update', ['brand' => $brand->id]), [
                'display_name' => $newBrand['display_name']
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_while_updating_brand_display_name_field_is_nullable()
    {
        $brand = Brand::factory()->create();
        $newBrand = Brand::factory()->raw();

        $response = $this->withExceptionHandling()
            ->putJson(route('brands.update', ['brand' => $brand->id]), [
                'name' => $newBrand['name']
            ])
            ->assertOk()->json();

        $this->assertEquals($newBrand['name'], $response['brand']['name']);
        $this->assertDatabaseHas('brands', ['id' => $brand->id, 'name' => $newBrand['name']]);
    }

    public function test_soft_delete_brand()
    {
        $brand = Brand::factory()->create();

        $this->deleteJson(route('brands.destroy', $brand->id))->assertOk()->json();

        $this->assertSoftDeleted('brands', ['id' => $brand->id]);
    }
}
