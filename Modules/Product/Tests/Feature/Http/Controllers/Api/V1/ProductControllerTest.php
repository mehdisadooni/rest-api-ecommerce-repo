<?php

namespace Modules\Product\Tests\Feature\Http\Controllers\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Entities\Product;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_products_use_pagination()
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('products.index'))->assertOk()->json();

        $this->assertEquals(1, count($response['products']));
        $this->assertEquals($product->name, $response['products'][0]['name']);
        $this->assertArrayHasKey('products', $response);
    }

    public function test_fetch_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('products.show', ['product' => $product->id]))->assertOk()->json();

        $this->assertEquals($product->name, $response['product']['name']);
    }

    public function test_store_new_product()
    {
        $this->withExceptionHandling();
        $product = Product::factory()->raw();
        $response = $this->postJson(route('products.store'),$product)->assertCreated()->json();
//        Storage::fake('public')->assertExists($response['product']['primary_image']);
        $this->assertEquals($product['name'], $response['product']['name']);
        $this->assertDatabaseHas('products', ['name' => $response['product']['name']]);
    }

    public function test_update_brand()
    {
        $product = Product::factory()->create();
        $newProduct = Product::factory()->raw();

        $response = $this->patchJson(route('products.update', $product->id), $newProduct)->assertOk()->json();

        $this->assertEquals($newProduct['name'], $response['product']['name']);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => $newProduct['name']]);
    }

    public function test_soft_delete_product()
    {
        $product = Product::factory()->create();

        $this->deleteJson(route('products.destroy', $product->id))->assertOk()->json();

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
