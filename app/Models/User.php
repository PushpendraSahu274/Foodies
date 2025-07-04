<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;
use App\Models\Address;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use UploadImageTrait;
    protected $appends = ['profile'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = [];

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

    public function getProfileAttribute()
    {
        if ($this->profile_path && $this->isCloudinaryResourceExists($this->profile_path)) {
            return $this->getCloudinaryResourceUrl($this->profile_path);
        }
        return null;
    }

    //cart 
    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

    public function isAdmin(): bool
    {
        return strtolower($this->role) === 'admin'; //true if admin
    }

    //default address
    public function default_address()
    {
        return $this->hasOne(Address::class, 'user_id', 'id')->where('is_default', 1);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function getAddressCountAttribute()
    {
        return $this->addresses->count();
    }

    public function orders(){
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
}
