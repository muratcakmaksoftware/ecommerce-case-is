<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterfaces\OrderRepositoryInterface;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    /**
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function getAllProductByCustomerId(): Collection
    {
        return $this->model->with(['products'])->where('customer_id', getCustomerId())->get();
    }

    /**
     * @return Model
     */
    public function getDefaultOrder(): Model
    {
        return $this->model->firstOrCreate([
            'customer_id' => getCustomerId()
        ]);
    }
}
