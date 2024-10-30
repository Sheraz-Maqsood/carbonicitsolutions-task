<?php

namespace App\Http\Controllers;

use App\Services\OrderSyncService;
use App\Jobs\SyncOrdersJob;
use App\Models\Order;

class OrderController extends Controller
{
    protected OrderSyncService $orderSyncService;

    public function __construct(OrderSyncService $orderSyncService)
    {
        $this->orderSyncService = $orderSyncService;
    }

    /**
     * Show the list of orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::with('user', 'products')->get(); // Eager load user and products

        return view('orders', compact('orders'));
    }

    /**
     * Sync a specific order with the external API.
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncOrderWithApi(Order $order)
    {
        // Dispatch the job to sync the order in the background
        SyncOrdersJob::dispatch([$order->toArray()]); // Pass only the order data

        return redirect()->route('orders.index')->with('message', 'Order sync initiated.');
    }
}
