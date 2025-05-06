<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'image',
        'seller_id',
    ];
    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }
    
    public function orders() {
        return $this->hasMany(Order::class);
    }
public function getImageSrc()
{
    if (!$this->image) {
        return null;
    }

    $finfo = new \finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($this->image);

    return 'data:' . $mimeType . ';base64,' . base64_encode($this->image);
}

    
}
