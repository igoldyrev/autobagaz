<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequestStoreRequest;
use App\Models\CallbackRequest;
use App\Services\OrderNotifications;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CallbackRequestController extends Controller
{
    public function store(CallbackRequestStoreRequest $request, OrderNotifications $notifications): RedirectResponse
    {
        $callbackRequest = DB::transaction(function () use ($request, $notifications) {
            $callbackRequest = CallbackRequest::query()->create($request->safe()->except('website'));
            $notifications->recordCallback($callbackRequest);

            return $callbackRequest;
        });

        $notifications->dispatchPending(callbackId: $callbackRequest->id);

        return back()
            ->with('callback_success', 'Заявка принята. Мы перезвоним вам в ближайшее время.')
            ->with('metrika_goal', 'callback_sent');
    }
}
