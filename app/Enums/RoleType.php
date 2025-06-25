<?php

namespace App\Enums;

enum RoleType: string
{
    case BUYER = 'buyer';
    case SELLER = 'seller';
    case ADMIN = 'admin';

    public static function all(): array
    {
        return [
            self::BUYER,
            self::SELLER,
            self::ADMIN,
        ];
    }
}
