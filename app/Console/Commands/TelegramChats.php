<?php

namespace App\Console\Commands;

use App\Services\TelegramNotifications;
use Illuminate\Console\Command;
use Throwable;

class TelegramChats extends Command
{
    protected $signature = 'telegram:chats';

    protected $description = 'List chat IDs of recent users who messaged the bot, without displaying the token';

    public function handle(TelegramNotifications $telegram): int
    {
        try {
            $chats = $telegram->recentChats();
        } catch (Throwable) {
            $this->components->error('Cannot fetch Telegram chats. Check the bot token and connectivity.');

            return self::FAILURE;
        }

        $this->table(['Chat ID', 'Name', 'Type'], $chats);
        if ($chats === []) {
            $this->components->info('Send /start to the bot, then run this command again.');
        }

        return self::SUCCESS;
    }
}
