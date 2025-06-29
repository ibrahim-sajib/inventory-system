<?php

namespace App\Contract\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    
    public function all(): Collection;
    public function updateProductStocks(array $products): void;

}