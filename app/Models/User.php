<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\MorphOne;
// use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Utils\CanRate;
use App\Utils\CanBeRated;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, CanRate, CanBeRated;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relación con la tabla products
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'created_by');
    }

    // public function rating(): MorphOne
    // {
    //     return $this->morphOne(Rating::class, 'qualifier');
    // }

    // public function ratings(): MorphMany
    // {
    //     return $this->morphMany(Rating::class, 'qualifier');
    // }
}
