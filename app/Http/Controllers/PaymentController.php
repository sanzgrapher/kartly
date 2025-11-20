<?php

namespace App\Http\Controllers;

use App\Services\Payment\EsewaService;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected EsewaService $esewaService;

    public function __construct(EsewaService $esewaService)
    {
        $this->esewaService = $esewaService;
    }


    public function esewaSuccess(Request $request)
    {
        $responseData = $this->esewaService->decodeResponse();

        if (!$responseData) {
            Log::error('eSewa: Invalid response data');
            return redirect()->route('checkout')
                ->with('error', 'Invalid payment response. Please try again.');
        }

        if ($responseData['status'] !== 'COMPLETE') {
            Log::error('eSewa: Payment failed', $responseData);
            return redirect()->route('checkout')
                ->with('error', 'Payment failed. Please try again.');
        }

        $payment = $this->esewaService->processSuccessfulPayment($responseData);

        if (!$payment) {
            Log::error('eSewa: Failed to save payment');
            return redirect()->route('checkout')
                ->with('error', 'Failed to process payment. Please contact support.');
        }

        return redirect()->route('orders.show', $payment->order_id)
            ->with('success', 'Payment successful! Your order has been confirmed.');
    }

    public function esewaFailure(Request $request)
    {
        $orderId = session('esewa_order_id');

        session()->forget('esewa_order_id');

        if ($orderId) {
            $payment = Payment::where('order_id', $orderId)->first();

            if ($payment) {
                $payment->payment_status = PaymentStatus::FAILED;
                $payment->save();
            }

            return redirect()->route('orders.show', $orderId)
                ->with('error', 'Payment was cancelled or failed. Please try again.');
        }

        return redirect()->route('checkout')
            ->with('error', 'Payment was cancelled or failed. Please try again.');
    }
}
