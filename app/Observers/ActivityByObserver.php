<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class ActivityByObserver
{
    protected function actorId(): ?int
    {
        return Auth::id(); // multi-guard লাগলে এখানে guard নির্দিষ্ট করো
    }

    public function creating($model): void
    {
        if ($id = $this->actorId()) {
            if (empty($model->created_by)) {
                $model->created_by = $id;
            }
            $model->updated_by = $id;
        }
    }

    public function updating($model): void
    {
        if ($id = $this->actorId()) {
            $model->updated_by = $id;
        }
    }

    public function deleting($model): void
    {
        if ($id = $this->actorId()) {
            // Soft delete হোক বা force delete—before delete mark the actor
            $model->deleted_by = $id;
            // avoid event loops
            $model->saveQuietly();
        }
    }

    public function restoring($model): void
    {
        // soft delete থেকে restore করলে clear করে দাও
        $model->deleted_by = null;
        $model->saveQuietly();
    }
}
