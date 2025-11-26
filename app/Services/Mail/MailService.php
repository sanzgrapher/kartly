<?php

namespace App\Services\Mail;

use App\Services\Mail\Contracts\MailServiceInterface;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\OrderConfirmationMail;
use App\Mail\NewOrderNotificationMail;
use App\Mail\OrderStatusUpdateMail;
use App\Mail\PaymentStatusUpdateMail;

class MailService implements MailServiceInterface
{
    /**
     * Send a welcome email to a new user.
     */
    public function sendWelcomeEmail(User $user): void
    {
        Mail::to($user->email)->queue(new WelcomeMail($user));
    }

    /**
     * Send an order confirmation email to the user.
   
     */
    public function sendOrderConfirmation(Order $order, User $user): void
    {
        Mail::to($user->email)->queue(new OrderConfirmationMail($order, $user));
    }

    /**
     * Send a new order notification email to the admin.
     */
    public function sendNewOrderNotification(Order $order): void
    {
        // use configurable admin email, fallback to default
        $adminEmail = config('mail.admin_address', 'admin@kartly.com');
        Mail::to($adminEmail)->queue(new NewOrderNotificationMail($order));
    }

    /**
     * Send an order status update email to the user.
     */
    public function sendOrderStatusUpdate(Order $order, User $user): void
    {
        Mail::to($user->email)->queue(new OrderStatusUpdateMail($order, $user));
    }

    /**
     * Send a payment status update email to the user.
     */
    public function sendPaymentStatusUpdate(Order $order, User $user): void
    {
        Mail::to($user->email)->queue(new PaymentStatusUpdateMail($order, $user));
    }
}
