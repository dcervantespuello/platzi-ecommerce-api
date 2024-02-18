<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_belongs_to_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
    }

    public function test_a_product_belongs_to_user()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['created_by' => $user->id]);

        $this->assertInstanceOf(User::class, $product->user);
    }
}
