<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Interfaces\RepositoryInterfaces\ProductRepositoryInterface;

class ProductService extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $repository;

    /**
     * @param ProductRepositoryInterface $repository
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
