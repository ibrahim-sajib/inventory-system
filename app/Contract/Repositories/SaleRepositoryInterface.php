<?php

namespace App\Contract\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface SaleRepositoryInterface extends BaseRepositoryInterface
{
        public function all(): Collection;
}