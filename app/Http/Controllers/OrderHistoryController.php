<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, int $id): View|RedirectResponse
    {
        $order = Order::with(['items.product'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        $orderStatus = strtolower((string) ($order->order_status ?? ''));

        // These flags drive the progress animation in resources/views/orders/show.blade.php
        $isCancelled = $orderStatus === 'cancelled';
        $isComplete = $orderStatus === 'completed';
        $isInProgress = in_array($orderStatus, ['shipped', 'completed'], true);
        $isPacked = in_array($orderStatus, ['processing', 'shipped', 'completed'], true);

        return view('orders.show', compact('order', 'isPacked', 'isInProgress', 'isComplete', 'isCancelled'));
    }
}
