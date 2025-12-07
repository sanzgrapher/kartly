<?php

namespace App\Services\Mail\Contracts;

use App\Models\User;
use App\Models\Order;

interface MailServiceInterface
{
    public function sendWelcomeEmail(User $user): void;

    public function sendOrderConfirmation(Order $order, User $user): void;

    public function sendNewOrderNotification(Order $order): void;

    public function sendOrderStatusUpdate(Order $order, User $user): void;

    public function sendPaymentStatusUpdate(Order $order, User $user): void;

    public function sendPaymentInvoice(Order $order, User $user): void;
}
