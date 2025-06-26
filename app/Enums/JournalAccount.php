<?php

namespace App\Enums;

enum JournalAccount: string
{
    case CASH = 'cash';
    case VAT = 'vat';
    case DISCOUNT = 'discount';
    case SALES = 'sales';
}