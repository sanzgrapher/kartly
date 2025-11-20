<?php

namespace App\Services\Payment;

use Xentixar\EsewaSdk\Esewa;
use App\Models\Payment;
use App\Models\Order;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\OrderStatus;
use Exception;
use Illuminate\Support\Facades\Log;

class EsewaService
{
    protected Esewa $esewa;

    public function __construct()
    {
        $this->esewa = new Esewa();
    }


    public function initiatePayment(Order $order,  $amount)
    {
        $transactionUuid = $this->generateTransactionUuid($order->id);


        $this->esewa->config(
            success_url: url('/payment/esewa/success'),
            failure_url: url('/payment/esewa/failure'),
            amount: $amount,
            transaction_uuid: $transactionUuid,
            product_code: 'EPAYTEST',
            secret_key: '8gBm/:&EnhH.1/q'
        );


        session(['esewa_order_id' => $order->id]);


        $this->esewa->init(false);
    }


    public function decodeResponse()
    {
        return $this->esewa->decode();
    }


    public function processSuccessfulPayment(array $responseData)
    {
        $orderId = session('esewa_order_id');

        if (!$orderId) {
            Log::error('eSewa payment: Order ID not found in session');
            return null;
        }

        $order = Order::find($orderId);

        if (!$order) {
            Log::error('eSewa payment: Order not found');
            return null;
        }

        $transactionCode = $responseData['transaction_code'];
        $transactionUuid = $responseData['transaction_uuid'];
        $amount = $responseData['total_amount'];

        $payment = Payment::where('order_id', $order->id)->first();

        if ($payment) {
            $payment->update([
                'payment_method' => PaymentMethod::ESEWA,
                'payment_status' => PaymentStatus::COMPLETED,
                'transaction_code' => $transactionCode,
                'transaction_uuid' => $transactionUuid,
                'amount' =>  $amount,
            ]);
        } else {
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => PaymentMethod::ESEWA,
                'payment_status' => PaymentStatus::COMPLETED,
                'transaction_code' => $transactionCode,
                'transaction_uuid' => $transactionUuid,
                'amount' =>  $amount,
            ]);
        }

        $order->status = OrderStatus::PROCESSING;
        $order->save();


        session()->forget('esewa_order_id');

        return $payment;
    }


    protected function generateTransactionUuid(int $orderId)
    {
        return 'ORD-' . $orderId . '-' . time() . '-' . rand(1000, 9999);
    }
}
