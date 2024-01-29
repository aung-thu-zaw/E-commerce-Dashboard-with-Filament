<?php

namespace App\Models;

use App\Notifications\Auth\ResetPasswordQueued;
use App\Notifications\Auth\VerifyEmailQueued;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasPermissions;
    use HasRoles;
    use Notifiable;
    use Searchable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * @return array<string>
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::needsRehash($value) ? bcrypt($value) : $value,
        );
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => str_starts_with($value, 'http') || ! $value ? "https://cdn2.iconfinder.com/data/icons/ecommerce-set-1-1/128/user_users_avatar_user_useri_icon-512.png" : asset("storage/avatars/users/$value"),
        );
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailQueued());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordQueued($token));
    }

    public static function deleteAvatar(?string $avatar): void
    {
        if (! empty($avatar) && file_exists(storage_path('app/public/avatars/users/'.pathinfo($avatar, PATHINFO_BASENAME)))) {
            unlink(storage_path('app/public/avatars/users/'.pathinfo($avatar, PATHINFO_BASENAME)));
        }
    }

    public function scopeFilterBy(Builder $query, ?array $filterBy): Builder
    {
        return $query
            ->when(isset($filterBy['status']) && in_array($filterBy['status'], ['active', 'suspended']), function ($query) use ($filterBy) {
                $query->where('status', $filterBy['status']);
            })
            ->when(isset($filterBy['role']) && in_array($filterBy['role'], ['admin', 'user']), function ($query) use ($filterBy) {
                $query->where('role', $filterBy['role']);
            });
    }
}
