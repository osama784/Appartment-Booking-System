<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        "start_date",
        "end_date",
        "owner_notes",
        "tenant_notes",
        "total_price",
        "number_of_guests",
        "status",
        "payment_status"
    ];

    protected $casts = [
        "start_date" => "date",
        "end_date" => "date",
    ];
}
