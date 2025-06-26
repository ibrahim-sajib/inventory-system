<?php

namespace App\Enums;

enum JournalType: string
{
    case DEBIT = 'debit';
    case CREDIT = 'credit';
}