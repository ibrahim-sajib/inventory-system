<?php

namespace App\Traits;

use App\Models\User;
use App\Observers\ActivityByObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait TracksActivityBy
{
    /**
     * Automatically boot the observer when trait is used.
     */
    public static function bootTracksActivityBy(): void
    {
        static::observe(ActivityByObserver::class);
    }

    /**
     * Get the user who created the model.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the model.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who deleted the model (soft deletes).
     */
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}