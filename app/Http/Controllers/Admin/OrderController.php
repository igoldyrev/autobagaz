<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderStatusRequest;
use App\Models\Order;
use App\Services\OrderWorkflow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()->with('assignee')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->when($request->boolean('mine'), fn ($query) => $query->where('assignee_id', $request->user()->id))
            ->when(! $request->boolean('mine') && $request->filled('assignee_id'), fn ($query) => $query->where('assignee_id', $request->input('assignee_id')))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.orders.index', ['orders' => $orders, 'managers' => app(OrderWorkflow::class)->managers()]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', ['order' => $order->load('items.product', 'assignee'), 'managers' => app(OrderWorkflow::class)->managers(), 'history' => app(OrderWorkflow::class)->history($order)]);
    }

    public function update(OrderStatusRequest $request, Order $order): RedirectResponse
    {
        app(OrderWorkflow::class)->update($order, $request->user(), $request->validated());

        return to_route('admin.orders.show', $order)->with('success', 'Заказ обновлён.');
    }
}
