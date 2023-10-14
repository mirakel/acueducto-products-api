<?php

namespace App\Repositories;

use App\Helpers\StringUtils;
use App\Interfaces\IProductRepository;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository implements IProductRepository
{

    public function getAllProducts()
    {
        return Product::select(['products.*', 'brands.name AS brand', 'products.price AS original_price'])
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->orderBy('created_at');
    }

    public function searchProducts(string $term)
    {
        $discount = StringUtils::isPalindrome($term) ? 0.5 : 0;

        return Product::select(['products.*', 'brands.name AS brand', 'products.price AS original_price'])
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('title', $term)
            ->orWhere('brands.name', 'like', "%$term%")
            ->orWhere('description', 'like', "%$term%")
            ->when($discount > 0, function ($query) {
                return $query->select([
                    'products.*', 'brands.name AS brand', 'products.price AS original_price' ,
                    DB::raw('price * 0.5 AS price')
                ]);
            })
            ->orderBy('created_at');
    }
}
