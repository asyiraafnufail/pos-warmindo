<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_superadmin', // Daftarkan di fillable untuk keamanan mass-assignment
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel otomatis meng-hash password menggunakan bcrypt/argon2id yang aman
        'is_superadmin' => 'boolean',
    ];

    /**
     * Security Guard: Hanya izinkan login jika is_superadmin bernilai true
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_superadmin === true;
    }
}