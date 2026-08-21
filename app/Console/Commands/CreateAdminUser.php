<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {email? : Адрес электронной почты администратора} {--name=Администратор : Имя администратора}';

    protected $description = 'Создать или обновить учётную запись администратора';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Email администратора');
        $name = (string) $this->option('name');
        $password = $this->secret('Пароль (не менее 12 символов)');
        $confirmation = $this->secret('Повторите пароль');

        $validator = Validator::make(
            compact('email', 'name', 'password', 'confirmation'),
            [
                'email' => ['required', 'email'],
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'same:confirmation', Password::min(12)],
            ],
            [
                'password.same' => 'Введённые пароли не совпадают.',
                'password.min' => 'Пароль должен содержать не менее 12 символов.',
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $admin = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
                'is_admin' => true,
                'role' => User::ROLE_ADMINISTRATOR,
                'permissions' => User::roleDefaultPermissions()[User::ROLE_ADMINISTRATOR],
            ],
        );

        $this->info($admin->wasRecentlyCreated
            ? 'Администратор успешно создан.'
            : 'Учётная запись администратора успешно обновлена.');

        return self::SUCCESS;
    }
}
