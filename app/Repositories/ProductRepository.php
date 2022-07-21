<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}
