<?php

namespace Modules\Product\Tests\Unit;

use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductImage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_image_belongs_to_a_product()
    {
        $productImage = ProductImage::factory()->create();
        $this->assertInstanceOf(Product::class, $productImage->product);
    }
}
