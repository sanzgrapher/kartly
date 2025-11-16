<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
    case DELIVERED = 'delivered';
    case FAILED = 'failed';
    case SHIPPED = 'shipped';
    case PROCESSING = 'processing';
}
