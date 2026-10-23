<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequestStoreRequest;
use App\Models\CallbackRequest;
use App\Services\OrderNotifications;
use App\Services\OrderWorkflow;
use App\Support\PersonalDataConsent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CallbackRequestController extends Controller
{
    public function store(CallbackRequestStoreRequest $request, OrderNotifications $notifications): RedirectResponse
    {
        $callbackRequest = DB::transaction(function () use ($request, $notifications) {
            $callbackRequest = CallbackRequest::query()->create([
                ...$request->safe()->except(['website', 'personal_data_consent', 'consent_version']),
                ...PersonalDataConsent::attributes(),
                'assignee_id' => app(OrderWorkflow::class)->defaultAssigneeId(),
            ]);
            $notifications->recordCallback($callbackRequest);

            return $callbackRequest;
        });

        $notifications->dispatchPending(callbackId: $callbackRequest->id);

        return back()
            ->with('callback_success', 'Заявка принята. Мы перезвоним вам в ближайшее время.')
            ->with('metrika_goal', 'callback_sent');
    }
}
