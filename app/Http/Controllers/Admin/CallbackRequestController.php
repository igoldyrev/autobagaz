<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CallbackRequestStatusRequest;
use App\Models\CallbackRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CallbackRequestController extends Controller
{
    public function index(Request $request): View
    {
        $callbackRequests = CallbackRequest::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.callback-requests.index', compact('callbackRequests'));
    }

    public function show(CallbackRequest $callbackRequest): View
    {
        return view('admin.callback-requests.show', compact('callbackRequest'));
    }

    public function update(CallbackRequestStatusRequest $request, CallbackRequest $callbackRequest): RedirectResponse
    {
        $callbackRequest->update($request->validated());

        return to_route('admin.callback-requests.show', $callbackRequest)->with('success', 'Статус заявки обновлён.');
    }
}
