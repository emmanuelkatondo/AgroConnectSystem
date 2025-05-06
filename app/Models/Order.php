<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'product_id',
        'buyer_id',
        'quantity',
        'status',
    ];
    public function product() {
        return $this->belongsTo(Product::class);
    }
    
    public function buyer() {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    
}
