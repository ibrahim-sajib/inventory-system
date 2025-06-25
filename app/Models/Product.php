<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'purchase_price',
        'sell_price',
        'stock',
    ];
    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'stock' => 'integer',
    ];
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSluggableColumnName(): string
    {
        return 'name';
    }
}
