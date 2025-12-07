<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public User $user;

    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function build()
    {
        $this->order->load(['items.product', 'payment']);

        $subtotal = $this->order->subtotal;
        if (!$subtotal || $subtotal <= 0) {
            $subtotal = $this->order->items->sum(function ($item) {
                return ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            });
        }

        $discount = $this->order->discount_amount ?? 0;
        $total = $this->order->total;

        if (!$total || $total <= 0) {
            $total = max(0, $subtotal - $discount);
        }

        $pdfOutput = null;
        try {
            $base64 = \Spatie\LaravelPdf\Facades\Pdf::view('pdf.invoice', ['order' => $this->order])
                ->name('invoice.pdf')
                ->base64();
            $pdfOutput = base64_decode($base64);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('PaymentInvoiceMail PDF Generation Failed: ' . $e->getMessage());
        }

        $mail = $this->subject('Payment Invoice - Order #' . $this->order->id)
            ->view('emails.payment-invoice');

        if ($pdfOutput) {
            $mail->attachData($pdfOutput, 'invoice.pdf', [
                'mime' => 'application/pdf',
            ]);
        }

        return $mail->with([
            'order' => $this->order,
            'user' => $this->user,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
        ]);
    }
}
