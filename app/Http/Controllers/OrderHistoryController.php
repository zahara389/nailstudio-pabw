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

        return view('orders.show', compact('order'));
    }
}
