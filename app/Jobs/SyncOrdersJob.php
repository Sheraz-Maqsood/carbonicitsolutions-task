<?php

namespace App\Jobs;

use App\Services\OrderSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class SyncOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $orders;

    /**
     * Create a new job instance.
     *
     * @param array $orders
     */
    public function __construct(array $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $orderSyncService = app(OrderSyncService::class);
            $orderSyncService->syncOrders($this->orders);

            Log::info('Successfully synced orders:', $this->orders);
        } catch (\Exception $e) {
            Log::error('Failed to sync orders:', [
                'error' => $e->getMessage(),
                'orders' => $this->orders,
            ]);
            throw $e;
        }
    }
}
