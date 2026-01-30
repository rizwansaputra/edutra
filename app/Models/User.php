<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
            'password'          => 'hashed',
        ];
    }

    /**
     * Batasi akses panel Filament berdasarkan panel id + role (Spatie).
     *
     * - /admin panel (id: admin) hanya role admin
     * - /student panel (id: student) role student atau user
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin'   => $this->hasRole('admin'),
            'student' => $this->hasRole('student') || $this->hasRole('user'),
            default   => false,
        };
    }

    /**
     * Courses yang diambil user.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(
                Course::class,
                'course_students',
                'user_id',
                'course_id'
            )
            ->withTimestamps()
            ->withPivot('deleted_at');
    }

    
}
