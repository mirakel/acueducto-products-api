<?php

namespace App\Interfaces;

interface IProductRepository {
    public function getAllProducts();
    public function searchProducts(string $term);
}
