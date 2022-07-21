<?php

namespace App\Http\Controllers;

use App\Enums\OrderStoreStatus;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use App\Traits\APIResponseTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use APIResponseTrait;

    /**
     * @var OrderService
     */
    private OrderService $service;

    /**
     * @param OrderService $service
     */
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Siparişe ait tüm ürünleri listeleme
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->responseSuccess(
            $this->service->index()
        );
    }

    /**
     * Siparişe ürün ekleme
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $status = $this->service->store($request->all());
        switch ($status) {
            case OrderStoreStatus::SUCCESS:
                return $this->responseStore();
            case OrderStoreStatus::PRODUCT_STOCK:
                return $this->responseBadRequest(null, 'products.stock');
            default: //OrderStoreStatus::ERROR
                return $this->responseBadRequest();
        }
    }

    /**
     * Siparişten ürünü siler ve sipariş total fiyatını günceller.
     *
     * @param $productId
     * @return JsonResponse
     */
    public function destroyByProductId($productId): JsonResponse
    {
        $this->service->destroyByProductId($productId);
        return $this->responseSuccess();
    }

    /**
     * *** Bir sipariş silindiğinde siparişe ait tüm bilgiler silinir. (Cascade bağlamından dolayı) ***
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if($this->service->destroy($id)){
            return $this->responseSuccess();
        }
        return $this->responseBadRequest();
    }

    /**
     * @return JsonResponse
     */
    public function discount(): JsonResponse
    {
        return $this->responseSuccess($this->service->discount());
    }
}
