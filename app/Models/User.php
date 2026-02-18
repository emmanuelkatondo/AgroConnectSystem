<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'region_id',
        'district_id',
        'ward_id',
        'role_id',
        'password',
    ];
    public function role() {
        return $this->belongsTo(Role::class);
    }
    
    public function region() {
        return $this->belongsTo(Region::class);
    }
    
    public function district() {
        return $this->belongsTo(District::class);
    }
    
    public function ward() {
        return $this->belongsTo(Ward::class);
    }
    
    public function products() {
        return $this->hasMany(Product::class, 'seller_id');
    }
    
    public function orders() {
        return $this->hasMany(Order::class, 'buyer_id');
    }
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
