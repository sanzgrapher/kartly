<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case ESEWA = 'esewa';
    case CASH_ON_DELIVERY = 'cash_on_delivery';

    public function label(): string
    {
        return match ($this) {
            self::ESEWA => 'eSewa',
            self::CASH_ON_DELIVERY => 'Cash on Delivery',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::ESEWA => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
            self::CASH_ON_DELIVERY => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
        };
    }
}
