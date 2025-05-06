<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    protected $fillable = [
        'name',
        'region_id',
    ];
    public function region() {
        return $this->belongsTo(Region::class);
    }
    public function wards() {
        return $this->hasMany(Ward::class);
    }
    public function users() {
        return $this->hasMany(User::class);
    }
}
