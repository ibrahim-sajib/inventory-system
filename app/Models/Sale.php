<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'subtotal',
        'discount',
        'vat',
        'total',
        'paid',
        'due',
    ];


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

}
