<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case ESEWA = 'esewa';
    case CASH_ON_DELIVERY = 'cash_on_delivery';
}
