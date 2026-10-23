<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderStatusRequest;
use App\Http\Requests\Admin\OrderTermsRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderTerms;
use App\Services\OrderWorkflow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()->with('assignee', 'acceptedTermsVersion')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->when($request->boolean('mine'), fn ($query) => $query->where('assignee_id', $request->user()->id))
            ->when(! $request->boolean('mine') && $request->filled('assignee_id'), fn ($query) => $query->where('assignee_id', $request->input('assignee_id')))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.orders.index', ['orders' => $orders, 'managers' => app(OrderWorkflow::class)->managers()]);
    }

    public function show(Request $request, Order $order): View
    {
        $filters = $request->validate(['product_search' => ['nullable', 'string', 'max:120']]);
        $search = trim($filters['product_search'] ?? '');
        $products = $search === '' ? collect() : Product::query()->active()
            ->where('name', 'like', '%'.$search.'%')->orderBy('name')->limit(20)->get(['id', 'name', 'price']);
        $oldProductIds = collect(array_keys((array) $request->old('additional_items', [])))
            ->filter(fn ($id) => filter_var($id, FILTER_VALIDATE_INT) !== false && (int) $id > 0)->take(100)->all();
        if ($oldProductIds !== []) {
            $products = $products->merge(Product::query()->whereIn('id', $oldProductIds)->get(['id', 'name', 'price']))->unique('id');
        }

        return view('admin.orders.show', [
            'additionalProducts' => $products,
            'productSearch' => $search,
            'order' => $order->load('items.product', 'assignee'),
            'managers' => app(OrderWorkflow::class)->managers(),
            'history' => app(OrderWorkflow::class)->history($order),
            'latestTerms' => $order->termsVersions()->first(),
        ]);
    }

    public function storeTerms(OrderTermsRequest $request, Order $order): RedirectResponse
    {
        app(OrderTerms::class)->propose($order, $request->user(), $request->validated());

        return to_route('admin.orders.show', $order)->with('success', 'Изменения сохранены. Передайте покупателю ссылку на заказ для подтверждения.');
    }

    public function update(OrderStatusRequest $request, Order $order): RedirectResponse
    {
        app(OrderWorkflow::class)->update($order, $request->user(), $request->validated());

        return to_route('admin.orders.show', $order)->with('success', 'Заказ обновлён.');
    }
}
