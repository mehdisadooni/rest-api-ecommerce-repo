<?php

namespace Modules\Category\Tests\Feature\Http\Controllers\Api\V1;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Category\Entities\Category;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_categories_using_pagination()
    {
        $category = Category::factory()->create();

        $response = $this->getJson(route('categories.index'));

        $this->assertEquals(1, count($response['categories']));
        $this->assertEquals($category->name, $response['categories'][0]['name']);
        $this->assertArrayHasKey('categories', $response);
    }

    public function test_fetch_single_category()
    {
        $category = Category::factory()->create();

        $response = $this->getJson(route('categories.show', ['category' => $category->id]))
            ->assertOk()
            ->json();

        $this->assertEquals($category->name, $response['category']['name']);
    }

    public function test_store_new_category()
    {
        $category = Category::factory()->raw();

        $response = $this->postJson(route('categories.store'), $category)
            ->assertCreated()
            ->json();
        $this->assertEquals($category['name'], $response['category']['name']);
        $this->assertDatabaseHas('categories', ['name' => $response['category']['name']]);
    }

    public function test_while_storing_category_name_field_is_required()
    {
        $this->withExceptionHandling()
            ->postJson(route('categories.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_update_category()
    {
        $category = Category::factory()->create();
        $newCategory = Category::factory()->raw();

        $response = $this->patchJson(route('categories.update', $category->id), [
            'name' => $newCategory['name'],
            'description' => $newCategory['description']
        ])->assertOk()->json();

        $this->assertEquals($newCategory['name'], $response['category']['name']);
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => $newCategory['name']]);
    }

    public function test_soft_delete_category()
    {
        $category = Category::factory()->create();

        $this->deleteJson(route('categories.destroy', $category->id))->assertOk();

        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }

    public function test_store_child_for_a_category()
    {
        $category = Category::factory()->create();
        $newCategory = Category::factory()->raw();
        $newCategory['parent_id'] = $category->id;

        $response = $this->postJson(route('categories.store'), $newCategory)
            ->assertCreated()
            ->json();

        $this->assertEquals($newCategory['name'], $response['category']['name']);
        $this->assertEquals($category['id'], $response['category']['parent_id']);
        $this->assertDatabaseHas('categories', ['name' => $response['category']['name']]);
    }

    public function test_fetch_children_of_category()
    {
        $category = Category::factory()->create();
        $child = Category::factory()->create(['parent_id' => $category->id]);

        $response = $this->getJson(route('categories.children', ['category' => $category->id]))->assertOk()->json();

        $this->assertEquals($child->name, $response['category']['children'][0]['name']);
        $this->assertDatabaseHas('categories', ['name' => $response['category']['name']]);
        $this->assertDatabaseHas('categories', ['name' => $response['category']['children'][0]['name']]);
    }

    public function test_fetch_parent_of_category()
    {
        $category = Category::factory()->create();
        $child = Category::factory()->create(['parent_id' => $category->id]);

        $response = $this->getJson(route('categories.parent', ['category' => $child->id]))->assertOk()->json();

        $this->assertEquals($category->name, $response['category']['parent']['name']);
        $this->assertDatabaseHas('categories', ['name' => $response['category']['name']]);
        $this->assertDatabaseHas('categories', ['name' => $response['category']['parent']['name']]);
    }
}
