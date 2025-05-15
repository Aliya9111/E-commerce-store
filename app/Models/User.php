<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users'; // Ensure this matches your table name
    protected $fillable = [
        'name',
        'email',
        'gender',
        'number',
        'dob',
        'password',
        'image',
        'status',
        'UserBlock',
        'rotation-angel1',
        'angle'
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
    ];

    public function orders(){
        return $this->hasMany(order::class,'user_id');
    }
    public function user_addresses(){
        return $this->hasOne(UserAddress::class,'user_id');
    }
    public function favouriteProduct(){
        return $this->hasMany(favouriteProduct::class,'user_id');
    }
    public function ProductsRating(){
        return $this->hasMany(ProductsRating::class,'user_id');
    }
    public function UserQuestions(){
        return $this->hasMany(UserQuestion::class,'user_id');
    }
}
