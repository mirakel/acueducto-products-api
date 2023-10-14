<?php

namespace App\Http\Controllers;

use App\Interfaces\IProductRepository;

class ProductController extends Controller
{
    private IProductRepository $productRepository;

    public function __construct(IProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        return $this->productRepository->getAllProducts()->paginate(10);
    }

    public function search(string $term)
    {
        return $this->productRepository->searchProducts($term)->paginate(10);
    }
}
