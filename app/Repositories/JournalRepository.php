<?php

namespace App\Repositories;

use App\Contract\Repositories\JournalRepositoryInterface;
use App\Models\Journal;
use App\Enums\JournalType;
use App\Enums\JournalAccount;
use App\Models\Sale;

class JournalRepository extends BaseRepository implements JournalRepositoryInterface
{
    public function __construct(Journal $model)
    {
        parent::__construct($model);
    }

    public function createJournalEntries(int $saleId, array $calc): void
    {
        $map = [
            'paid'     => [JournalType::DEBIT,  JournalAccount::CASH],
            'subtotal' => [JournalType::CREDIT, JournalAccount::SALES],
            'vat'      => [JournalType::CREDIT, JournalAccount::VAT],
            'discount' => [JournalType::CREDIT, JournalAccount::DISCOUNT],
            'due'      => [JournalType::CREDIT, JournalAccount::DUE],
        ];

        $entries = [];
        foreach ($map as $key => [$type, $account]) {
            if (!empty($calc[$key])) {
                $entries[] = [
                    'type'    => $type,
                    'account' => $account,
                    'amount'  => $calc[$key],
                ];
            }
        }

        if (!empty($entries)) {
            $sale = Sale::find($saleId);
            $sale?->journals()->createMany($entries);
        }
    }
}