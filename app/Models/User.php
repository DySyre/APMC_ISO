<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    const ROLE_ADMIN  = 1;
    const ROLE_LEADER = 2;
    const ROLE_USER   = 3;

    public static function roleName($role): string
    {
        return match ($role) {
            1 => 'Admin',
            2 => 'Leader',
            3 => 'User',
            default => 'Unknown',
        };
    }

    protected $fillable = [
    'name',
    'first_name',
    'last_name',
    'badge_number',
    'division',
    'email',
    'password',
    'role',
    'last_login_at',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    //Concatenated full name accessor
    public function getNameAttribute()
{
    return "{$this->first_name} {$this->last_name}";
}

public function isAdmin(): bool
{
    return $this->role === self::ROLE_ADMIN;
}

public function isLeader(): bool
{
    return $this->role === self::ROLE_LEADER;
}

public function isUser(): bool
{
    return $this->role === self::ROLE_USER;
}

public function hasRole($roles): bool
{
    $roles = is_array($roles) ? $roles : explode(',', $roles);
    return in_array($this->role, $roles);
}

public function inDivision($division): bool
{
    return $this->division === $division;
}

public function managesDivision(): bool
{
    return $this->isLeader() && !empty($this->division);
}

}