<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appartment extends Model
{
    protected $fillable = [
        "description",
        "price_per_night",
        "price_per_month",
        "max_guests",
        "bedrooms",
        "bathrooms",
        "address",
        "governorate",
        "city",
        "latitude",
        "longitude",
    ];
}
