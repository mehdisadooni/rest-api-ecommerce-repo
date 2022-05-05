<?php

namespace Modules\Product\Tests\Unit;

use Illuminate\Support\Collection;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductImage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
    }

    public function test_a_product_can_has_many_images()
    {
        ProductImage::factory()->create([
            'product_id' => $this->product->id,
            'image' => 'test.jpg'
        ]);
        $this->assertInstanceOf(Collection::class, $this->product->images);
        $this->assertInstanceOf(ProductImage::class, $this->product->images->first());
    }

    public function test_product_belongs_to_a_brand()
    {
        $this->assertInstanceOf(Brand::class, $this->product->brand);
    }

    public function test_product_belongs_to_a_category()
    {
        $this->assertInstanceOf(Category::class, $this->product->category);
    }

    public function test_if_product_is_force_deleted_then_all_its_images_will_be_force_deleted()
    {
        $productImage = ProductImage::factory()->create([
            'product_id' => $this->product->id,
            'image' => 'test.jpg'
        ]);

        //create another product and image
        $anotherProductImage = ProductImage::factory()->create([
            'image' => 'test2.jpg'
        ]);
//        delete province
        $this->product->forceDelete();
        $this->assertDatabaseMissing('products', ['id' => $this->product->id]);
        $this->assertDatabaseMissing('product_images', ['id' => $productImage->id]);
        $this->assertDatabaseHas('product_images', ['id' => $anotherProductImage->id]);
    }

}
