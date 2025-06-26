<?php

namespace App\Listeners;

use App\Events\SaleCreated;
use App\Contract\Repositories\JournalRepositoryInterface;

class CreateJournalEntries
{

    public function __construct(protected JournalRepositoryInterface $journalRepository)
    {
    }

    public function handle(SaleCreated $event): void
    {
        $sale = $event->sale;
        $calc = $event->calculation;

        $this->journalRepository->createJournalEntries($sale->id, $calc);
    }
}