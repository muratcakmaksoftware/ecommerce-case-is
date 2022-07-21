<?php

namespace App\Interfaces\RepositoryInterfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface OrderRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllProductByCustomerId(): Collection;

    /**
     * @return Model
     */
    public function getDefaultOrder(): Model;
}
