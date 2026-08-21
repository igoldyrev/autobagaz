<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'password', 'is_admin', 'role', 'permissions', 'last_login_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_USER = 'user';

    public const ROLE_CONTENT_MANAGER = 'content_manager';

    public const ROLE_ADMINISTRATOR = 'administrator';

    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const PERMISSION_PRODUCTS = 'products.manage';

    public const PERMISSION_CATEGORIES = 'categories.manage';

    public const PERMISSION_VEHICLES = 'vehicles.manage';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'permissions' => 'array',
        ];
    }

    /** @return array<string, string> */
    public static function roleLabels(): array
    {
        return [
            self::ROLE_USER => 'Пользователь без доступа к админке',
            self::ROLE_CONTENT_MANAGER => 'Контент-менеджер',
            self::ROLE_ADMINISTRATOR => 'Администратор',
            self::ROLE_SUPER_ADMIN => 'Главный администратор',
        ];
    }

    /** @return array<string, string> */
    public static function permissionLabels(): array
    {
        return [
            self::PERMISSION_PRODUCTS => 'Управление товарами и производителями',
            self::PERMISSION_CATEGORIES => 'Управление разделами и категориями',
            self::PERMISSION_VEHICLES => 'Управление марками и моделями автомобилей',
        ];
    }

    /** @return array<string, array<int, string>> */
    public static function roleDefaultPermissions(): array
    {
        return [
            self::ROLE_USER => [],
            self::ROLE_CONTENT_MANAGER => [self::PERMISSION_PRODUCTS, self::PERMISSION_CATEGORIES],
            self::ROLE_ADMINISTRATOR => array_keys(self::permissionLabels()),
            self::ROLE_SUPER_ADMIN => array_keys(self::permissionLabels()),
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->is_admin && (blank($this->role) || $this->role === self::ROLE_USER)) {
            return in_array($permission, self::roleDefaultPermissions()[self::ROLE_ADMINISTRATOR], true);
        }

        return in_array($permission, $this->permissions ?? self::roleDefaultPermissions()[$this->role] ?? [], true);
    }

    public function roleLabel(): string
    {
        return self::roleLabels()[$this->role] ?? 'Без роли';
    }

    public function scopeSuperAdministrators(Builder $query): Builder
    {
        return $query->where('role', self::ROLE_SUPER_ADMIN);
    }
}
