<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

use app\Models\Comment;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    
    //Uuid trait for automatic UUID generation
    use HasFactory, HasUuids;//, Notifiable;

    // Moved fillable property inside the class body and add 'uuid'
    protected $fillable = [
        'username', 
        'name', 
        'email', 
        'password', 
        'gender'
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    //Explicit ly define the unique IDs for the model
     public function uniqueIds(): array
    {
        return ['uuid'];
    }


    //atribui getRouteKeyName para usar uuid como chave primária na rota
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

        protected function casts(): array
    {
        return [
            //'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
