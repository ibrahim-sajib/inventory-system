<?php

namespace App\Contract\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all products.
     *
     * @return mixed
     */
    public function all(): Collection;

    // Add product-specific repository methods here
}