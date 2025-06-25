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

}