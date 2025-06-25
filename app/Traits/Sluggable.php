<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Sluggable
{
    public static function bootSluggable(): void
    {
        static::creating(function (Model $model) {
            $columnName = $model->getSluggableColumnName();
            $model->slug = $model->generateSlug($model->{$columnName}, $columnName);
        });
    }

    private function generateSlug(string $columnValue, $columnName): string
    {
        $slug = Str::slug($columnValue, '-', 'ja');
        if (static::where('slug', $slug)->exists()) {
            $counter = 2;

            while (static::where('slug', $slug)->exists()) {
                $slug = "{$slug}-{$counter}";
                $counter++;
            }
        }

        return $slug;
    }
}
