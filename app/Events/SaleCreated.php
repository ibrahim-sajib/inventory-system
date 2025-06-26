<?php

namespace App\Events;

use App\Models\Sale;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SaleCreated
{
    use Dispatchable, SerializesModels;

    public Sale $sale;
    public array $calculation;

    public function __construct(Sale $sale, array $calculation)
    {
        $this->sale = $sale;
        $this->calculation = $calculation;
    }
}