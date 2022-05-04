<?php

namespace Modules\Category\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Modules\Category\Entities\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_category_can_has_many_children()
    {
        $category = Category::factory()->create();

        Category::factory()->create(['parent_id' => $category->id]);

        $this->assertInstanceOf(Collection::class, $category->children);
        $this->assertInstanceOf(Category::class, $category->children->first());
    }

    public function test_if_category_is_soft_deleted_then_all_its_children_will_be_soft_deleted()
    {
        $category = Category::factory()->create();
        $child = Category::factory()->create(['parent_id' => $category->id]);

        //create another category and child
        $anotherCategory = Category::factory()->create();
        $anotherChild = Category::factory()->create(['parent_id' => $anotherCategory->id]);

        //delete category
        $category->delete();
        $this->assertSoftDeleted('categories', ['id' => $category->id]);
        $this->assertSoftDeleted('categories', ['id' => $child->id]);
        $this->assertDatabaseHas('categories', ['id' => $anotherChild->id]);
    }

    public function test_a_category_can_has_parent()
    {
        $category = Category::factory()->create();
        $child = Category::factory()->create(['parent_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $child->parent);
    }
}
