<?php

namespace App\Repositories;

use App\Contract\Repositories\SaleRepositoryInterface;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

class SaleRepository extends BaseRepository implements SaleRepositoryInterface
{
    public function __construct(Sale $model)
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