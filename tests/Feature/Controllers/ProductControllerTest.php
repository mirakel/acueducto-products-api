<?php

namespace Tests\Feature\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_products(): void
    {
        Product::factory(10)->create();
        $res = $this->get('/api/products');
        $res->assertStatus(200);
        $res->assertJsonFragment([
            'current_page' => 1,
            'total'        => 10,
        ]);
    }

    public function test_returns_a_successful_response(): void
    {
        $res = $this->get('/api/search/lg');
        $res->assertStatus(200);
        $res->assertJsonFragment([
            'current_page' => 1,
            'data'         => [],
            'total'        => 0,
        ]);
    }

    public function test_search_products(): void
    {
        Product::factory(5)->create();
        $brand   = Brand::factory()->create(['name' => 'Samsung']);
        $product = Product::factory()->create(['title' => 'Samsung Tv', 'brand_id' => $brand->getKey()]);
        $res     = $this->get('/api/search/samsung');
        $res->assertStatus(200);
        $res->assertJsonFragment([
            'current_page' => 1,
            'data'         => [
                [
                    'title'          => $product->title,
                    'brand_id'       => $brand->getKey(),
                    'brand'          => $brand->name,
                    'id'             => $product->getKey(),
                    'price'          => $product->price,
                    'original_price' => $product->price,
                    'description'    => $product->description,
                    'image_url'      => $product->image_url,
                    'created_at'     => $product->created_at->format('Y-m-d\TH:i:s.u\Z'),
                    'updated_at'     => $product->updated_at->format('Y-m-d\TH:i:s.u\Z'),
                ],
            ],
            'total'        => 1,
        ]);
    }
}
