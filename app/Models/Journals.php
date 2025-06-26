<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\JournalType;
use App\Enums\JournalAccount;

class Journal extends Model
{
    protected $fillable = [
        'sale_id',
        'type',
        'account',
        'amount',
    ];

    protected $casts = [
        'type' => JournalType::class,
        'account' => JournalAccount::class,
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
