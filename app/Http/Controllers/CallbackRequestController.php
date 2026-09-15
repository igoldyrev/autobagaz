<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequestStoreRequest;
use App\Mail\CallbackRequested;
use App\Models\CallbackRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class CallbackRequestController extends Controller
{
    public function store(CallbackRequestStoreRequest $request): RedirectResponse
    {
        $callbackRequest = CallbackRequest::query()->create($request->safe()->except('website'));

        Mail::to(config('orders.notification_email'))->queue(new CallbackRequested($callbackRequest));

        return back()->with('callback_success', 'Заявка принята. Мы перезвоним вам в ближайшее время.');
    }
}
