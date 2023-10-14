<?php

namespace Tests\Feature\Repositories;

use App\Interfaces\IProductRepository;
use App\Models\Brand;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private IProductRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProductRepository();
    }

    public function test_returns_all_products()
    {
        Product::factory(5)->create();
        $products = $this->repository->getAllProducts()->get();
        $this->assertCount(5, $products);
    }

    public function test_returns_products_without_discount_if_search_term_is_not_palindrome()
    {
        $brand = Brand::factory()->create(['name' => 'Samsung Company']);
        Product::factory()->create(['title' => 'Samsung', 'price' => 10000]);
        Product::factory()->create(['description' => 'This is a text with samsung', 'price' => 3000]);
        Product::factory()->create(['brand_id' => $brand->getKey(), 'price' => 5000]);
        $products = $this->repository->searchProducts('samsung')->get();
        $this->assertCount(3, $products);
        foreach ($products as $product) {
            $this->assertEquals($product->original_price, $product->price);
        }
    }

    public function test_returns_products_with_discount_if_search_term_is_palindrome()
    {
        $brand = Brand::factory()->create(['name' => 'LCD abba']);
        Product::factory()->create(['title' => 'Abba', 'price' => 1000]);
        Product::factory()->create(['description' => 'This is a text with abba', 'price' => 3000]);
        Product::factory()->create(['brand_id' => $brand->getKey(), 'price' => 5000]);
        $products = $this->repository->searchProducts('abba')->get();
        $this->assertCount(3, $products);
        foreach ($products as $product) {
            $this->assertEquals($product->original_price * 0.5, $product->price);
        }
    }
}
