<?php

namespace App\Contract\Repositories;

interface JournalRepositoryInterface extends BaseRepositoryInterface
{
    public function createJournalEntries(int $saleId, array $calc): void;
}