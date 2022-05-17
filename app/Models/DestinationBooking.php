<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationBooking extends Model
{
    // use HasFactory;
    protected $table = 'destination_booking';

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function userBanyuwangitourism()
    {
        return $this->belongsTo(UserBanyuwangitourism::class);
    }
}
