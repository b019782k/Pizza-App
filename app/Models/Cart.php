<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function pizza(){
        return $this->belongsTo(Pizza::class);
    }

    public function cartDetails(){
        return $this->hasMany(CartDetail::class);
    }
}
