<?php

namespace App\Jobs;

use App\Repositories\PaymentRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyWalletService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $transactionId;

    protected int $statusId;

    /**
     * Create a new job instance.
     *
     * @param int $transactionId
     * @param int $statusId
     */
    public function __construct(int $transactionId, int $statusId)
    {
        $this->transactionId = $transactionId;
        $this->statusId = $statusId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        PaymentRepository::notifyWallet($this->transactionId, $this->statusId);
    }
}
