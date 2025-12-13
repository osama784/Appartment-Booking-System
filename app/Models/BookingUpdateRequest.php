<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingUpdateRequest extends Model
{
    protected $fillable = [
        "requested_number_of_guests",
        "requested_start_date",
        "requested_end_date",
        "requested_tenant_notes",
        "status"
    ];

    protected $casts = [
        "requested_start_date" => "date",
        "requested_end_date" => "date"
    ];
}
