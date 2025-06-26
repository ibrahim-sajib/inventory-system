<?php

namespace App\Repositories;

use App\Contract\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    // Get all products
    public function all(): Collection
    {
        return $this->model->orderBy('created_at', 'desc')->get();
        // should be paginated, but applied this for faster at this time
    }

    public function updateProductStock(int $productId, int $quantity): bool
    {
        $product = $this->model->find($productId);
        if ($product && $product->stock >= $quantity) {
            $product->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    public function updateProductStocks(array $products): void
    {
        //should be more optimized
        foreach ($products as $item) {
            $product = $this->model->find($item['product_id']);
            if ($product && $product->stock >= ($item['quantity'] ?? 0)) {
                $product->decrement('stock', $item['quantity']);
            }
        }
    }
}