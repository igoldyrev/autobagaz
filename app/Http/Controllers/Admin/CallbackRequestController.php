<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CallbackRequestStatusRequest;
use App\Models\CallbackRequest;
use App\Services\OrderWorkflow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CallbackRequestController extends Controller
{
    public function index(Request $request): View
    {
        $callbackRequests = CallbackRequest::query()->with('assignee')
            ->when($request->boolean('archived'), fn ($query) => $query->whereNotNull('archived_at'), fn ($query) => $query->whereNull('archived_at'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->when($request->boolean('mine'), fn ($query) => $query->where('assignee_id', $request->user()->id))
            ->when(! $request->boolean('mine') && $request->filled('assignee_id'), fn ($query) => $query->where('assignee_id', $request->input('assignee_id')))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.callback-requests.index', ['callbackRequests' => $callbackRequests, 'managers' => app(OrderWorkflow::class)->managers()]);
    }

    public function show(CallbackRequest $callbackRequest): View
    {
        return view('admin.callback-requests.show', ['callbackRequest' => $callbackRequest->load('assignee'), 'managers' => app(OrderWorkflow::class)->managers(), 'history' => app(OrderWorkflow::class)->history($callbackRequest)]);
    }

    public function update(CallbackRequestStatusRequest $request, CallbackRequest $callbackRequest): RedirectResponse
    {
        app(OrderWorkflow::class)->update($callbackRequest, $request->user(), $request->validated());

        return to_route('admin.callback-requests.show', $callbackRequest)->with('success', 'Заявка обновлена.');
    }
}
