<?php

namespace App\Repositories;

use App\Contract\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected readonly Model $model)
    {
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data): Model
    {
        /** @var Model $model */
        $model = $this->model->findOrFail($id);

        $model->update($data);

        return $model->refresh();
    }

    public function delete(int $id): bool
    {
        $model = $this->find($id);

        return $model->delete();
    }
}
