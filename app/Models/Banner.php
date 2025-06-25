<?php

namespace App\Models;

use App\Enums\BannerStatus;
use App\Enums\BannerType;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'photo',
        'status',
        'type',
    ];

    protected $casts = [
        'status' => BannerStatus::class,
        'type' => BannerType::class,
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSluggableColumnName(): string
    {
        return 'title';
    }
}
