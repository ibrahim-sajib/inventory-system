<?php

namespace App\Repositories;

use App\Contract\Repositories\JournalRepositoryInterface;
use App\Models\Journal;
use App\Enums\JournalType;
use App\Enums\JournalAccount;
use App\Models\Sale;
use Carbon\Carbon;

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

    public function getJournalEntriesByDateRange(?string $from = null, ?string $to = null): array
    {
        $from = $from ? Carbon::parse($from)->startOfDay() : now()->subDays(6)->startOfDay();
        $to   = $to   ? Carbon::parse($to)->endOfDay()   : now()->endOfDay();

        $journals = $this->model
            ->whereBetween('created_at', [$from, $to])
            ->get();

        // Total Sales (Credit, Sales account)
        $totalSales = $journals
            ->where('type', JournalType::CREDIT)
            ->where('account', JournalAccount::SALES)
            ->sum('amount');

        // Total Expenses (Credit, Discount account)
        $totalExpenses = $journals
            ->where('type', JournalType::CREDIT)
            ->where('account', JournalAccount::DISCOUNT)
            ->sum('amount');

        return [
            'from'          => $from->toDateString(),
            'to'            => $to->toDateString(),
            'total_sales'   => $totalSales,
            'total_expenses'=> $totalExpenses,
            'journals'      => $journals,
        ];
    }
}