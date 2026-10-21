<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class TelegramNotifications
{
    /** @return list<string> */
    public function alertRecipients(): array
    {
        return $this->recipients(config('services.telegram.alert_chat_ids'));
    }

    /** @return list<string> */
    private function recipients(?string $configured): array
    {
        if (! config('services.telegram.bot_token')) {
            return [];
        }

        return array_values(array_unique(array_filter(array_map('trim', explode(',', $configured ?? '')), fn ($id) => $id !== '')));
    }

    public function send(string $chatId, string $text): void
    {
        $this->request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'link_preview_options' => ['is_disabled' => true],
        ]);
    }

    /** @return list<array{id: string, name: string, type: string}> */
    public function recentChats(): array
    {
        $chats = [];
        foreach ($this->request('getUpdates', ['limit' => 100, 'timeout' => 0]) as $update) {
            $chat = $update['message']['chat'] ?? $update['my_chat_member']['chat'] ?? null;
            if (! $chat) {
                continue;
            }
            $chats[(string) $chat['id']] = [
                'id' => (string) $chat['id'],
                'name' => $chat['title'] ?? trim(($chat['first_name'] ?? '').' '.($chat['last_name'] ?? '')),
                'type' => $chat['type'],
            ];
        }

        return array_values($chats);
    }

    /** @param array<string, mixed> $parameters
     * @return array<mixed>
     */
    private function request(string $method, array $parameters): array
    {
        $token = config('services.telegram.bot_token');
        if (! $token) {
            throw new RuntimeException('Telegram bot token is not configured.');
        }

        try {
            $request = Http::connectTimeout(5)->timeout(15);
            $proxy = config('services.telegram.proxy_url');
            if ($proxy) {
                $request->withOptions(['proxy' => $proxy]);
            }
            $response = $request->post('https://api.telegram.org/bot'.$token.'/'.$method, $parameters);
        } catch (Throwable) {
            // HTTP exceptions may contain the bot token and proxy credentials.
            throw new RuntimeException('Telegram API connection failed.');
        }

        if (! $response->successful() || $response->json('ok') !== true) {
            throw new RuntimeException('Telegram API rejected the request (HTTP '.$response->status().').');
        }

        return (array) $response->json('result', []);
    }
}
