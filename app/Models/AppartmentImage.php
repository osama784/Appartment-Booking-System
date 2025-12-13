<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppartmentImage extends Model
{
    protected $fillable = [
        "is_main",
        "display_order"
    ];
}
