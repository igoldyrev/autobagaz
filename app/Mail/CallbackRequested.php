<?php

namespace App\Mail;

use App\Models\CallbackRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CallbackRequested extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public CallbackRequest $callbackRequest) {}

    public function build(): self
    {
        return $this->subject('Новая заявка на обратный звонок')
            ->view('emails.callback-requests.created');
    }
}
