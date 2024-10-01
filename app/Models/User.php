<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

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

    public function canAccessPanel(Panel $panel): bool
    {
        // Extrair o domínio da URL
        $appUrl = env('APP_URL');
        $parsedUrl = parse_url($appUrl, PHP_URL_HOST); // Extrai apenas o domínio (host)

        return str_ends_with($this->email, '@' . $parsedUrl) && $this->hasVerifiedEmail();
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCorretor()
    {
        return $this->role === 'corretor';
    }

    // Relacionamento: Um usuário pode ter muitos imóveis
    public function properties()
    {
        return $this->hasMany(Property::class);
    }


}
