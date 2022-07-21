<?php

namespace App\Services;

use App\Enums\OrderStoreStatus;
use App\Http\Controllers\Controller;
use App\Interfaces\RepositoryInterfaces\OrderRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\ProductRepositoryInterface;
use App\Models\OrderProduct;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;

class OrderService extends Controller
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $repository;

    /**
     * @param OrderRepositoryInterface $repository
     */
    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Siparişe ait tüm ürünleri listeleme
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->repository->getAllProductByCustomerId();
    }

    /**
     * Siparişe ürün ekleme
     *
     * @param array $attributes
     * @return int
     * @throws BindingResolutionException
     */
    public function store(array $attributes): int
    {
        $order = $this->repository->getDefaultOrder();
        $product = app()->make(ProductRepositoryInterface::class)->getById($attributes['product_id']);

        if ($order && $product) {
            if ($attributes['quantity'] > $product->stock) {
                return OrderStoreStatus::PRODUCT_STOCK;
            }

            $total = $product->price * $attributes['quantity'];
            $order->products()->syncWithoutDetaching([
                $product->id => [
                    'quantity' => $attributes['quantity'],
                    'unit_price' => $product->price,
                    'total' => $total
                ]
            ]);

            $this->repository->update($order->id, [
                'total' => $order->total + $total
            ]);

            return OrderStoreStatus::SUCCESS;
        }
        return OrderStoreStatus::ERROR;
    }

    /**
     * Siparişten ürünü siler ve sipariş total fiyatını günceller.
     *
     * @param $productId
     * @return void
     */
    public function destroyByProductId($productId)
    {
        $order = $this->repository->getDefaultOrder();
        //Sipariş totalinden ürünün fiyatını düşürme ve siparişten ürünü silme. (Repository dışında bir örnek)
        $orderProduct = OrderProduct::where('order_id', $order->id)->where('product_id', $productId)->first();
        if ($orderProduct) {
            $order->total -= $orderProduct->total;
            if ($order->save()) {
                $order->products()->detach($productId);
            }
        }
    }

    /**
     * *** Bir sipariş silindiğinde siparişe ait tüm bilgiler silinir. (Cascade bağlamından dolayı) ***
     *
     * @param $id
     * @return bool
     */
    public function destroy($id): bool
    {
        return $this->repository->destroy($id);
    }

    /**
     * Siparişteki indirimleri hesaplar
     *
     * @return array
     */
    public function discount(): array
    {
        /**
         * Buradaki her algoritma metotlara ayrılabilir ben bilerek ayırmadım
         * Metotlara ayrıldığında tüm kontroller için daha fazla çok döngüye sahip olmuş oluyor buda daha fazla işlem
         * yapacağı anlamına geliyor. Tercihler kişiye göre değişebilir burada performans odaklı ilerlenmiştir
         */

        $order = $this->repository->getDefaultOrder();
        $discountedTotal = $order->total;
        $totalDiscount = 0;
        $discount = [];

        $total1000 = 0;
        $justOneTimeCategory2Sold6Free1Status = false;
        $category1Sold2Count = 0;
        $category1Sold2CheapestPrice = 0;
        foreach ($order->products as $product) {

            //10_PERCENT_OVER_1000
            $total1000 += $product->pivot->total;

            //CATEGORY_2_SOLD_6_FREE_1
            if ($justOneTimeCategory2Sold6Free1Status === false && $product->category_id == 2) {
                if ($product->pivot->quantity === 6) { //6 adet alındığından dendiğinden dolayı sadece 6 adet.
                    $justOneTimeCategory2Sold6Free1Status = true;
                    $discountedTotal = round($discountedTotal - $product->pivot->unit_price);
                    $discountAmount = round($product->pivot->unit_price, 2);
                    $discount[] = [
                        "discountReason" => "CATEGORY_2_SOLD_6_FREE_1",
                        "discountAmount" => $discountAmount,
                        "subtotal" => $discountedTotal
                    ];

                    $totalDiscount = round($totalDiscount + $discountAmount, 2);
                }
            }

            //CATEGORY_1_SOLD_2_CHEAPEST
            if ($product->category_id == 1) {
                if ($category1Sold2CheapestPrice == 0) { //set default min price
                    $category1Sold2CheapestPrice = $product->pivot->unit_price;
                } else if ($category1Sold2CheapestPrice > $product->pivot->unit_price) { //detect min price
                    $category1Sold2CheapestPrice = $product->pivot->unit_price;
                }
                $category1Sold2Count++;
            }
        }

        //10_PERCENT_OVER_1000 //Toplam sipariş bilgisinden de kontrol edilebilirdi ancak hesaplama istendiği için eklendi.
        if ($total1000 >= 1000) {
            $percent = round(calculatePercent($discountedTotal, 10), 2);
            $discountedTotal = round($discountedTotal - $percent, 2);
            $discountAmount = $percent;
            $discount[] = [
                "discountReason" => "10_PERCENT_OVER_1000",
                "discountAmount" => $discountAmount,
                "subtotal" => $discountedTotal
            ];

            $totalDiscount = round($totalDiscount + $discountAmount, 2);
        }

        //CATEGORY_1_SOLD_2_CHEAPEST
        if ($category1Sold2Count >= 2) {
            $percent = round(calculatePercent($category1Sold2CheapestPrice, 20), 2);
            $discountedTotal = round($discountedTotal - $percent, 2);
            $discountAmount = $percent;
            $discount[] = [
                "discountReason" => "CATEGORY_1_SOLD_2_CHEAPEST",
                "discountAmount" => $discountAmount,
                "subtotal" => $discountedTotal
            ];

            $totalDiscount = round($totalDiscount + $discountAmount, 2);
        }

        return [
            'order_id' => $order->id,
            'discount' => $discount,
            "totalDiscount" => $totalDiscount,
            "discountedTotal" => $discountedTotal
        ];
    }
}
