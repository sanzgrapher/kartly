<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Console\Command;

class CancelExpiredPendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel eSewa payments that have been pending for more than 30 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTime = now()->subMinutes(30);

        $expiredPayments = Payment::where('payment_method', PaymentMethod::ESEWA)
            ->where('payment_status', PaymentStatus::PENDING)
            ->where('created_at', '<', $expiredTime)
            ->get();

        $count = 0;

        foreach ($expiredPayments as $payment) {
            $payment->update([
                'payment_status' => PaymentStatus::FAILED,
            ]);
            $count++;
        }

        $this->info("Cancelled {$count} expired pending payments.");

        return Command::SUCCESS;
    }
}
