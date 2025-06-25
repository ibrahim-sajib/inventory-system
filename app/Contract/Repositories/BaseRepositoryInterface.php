<?php

namespace App\Contract\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function create(array $data): Model;

    public function find(int $id): Model;

    public function update(int $id, array $data): Model;

    public function delete(int $id): bool;
}
