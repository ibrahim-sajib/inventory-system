<?php

namespace App\Repositories;

use App\Contract\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create(array $payload): Model
    {
        $user = $this->model->create($payload);
        event(new Registered($user));
        Auth::login($user);

        return $user->refresh();
    }
}
