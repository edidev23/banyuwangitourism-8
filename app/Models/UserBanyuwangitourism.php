<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBanyuwangitourism extends Model
{
    // use HasFactory;
    protected $table = 'user_banyuwangitourism';

    public function destinationBooking()
    {
        return $this->hasMany(DestinationBooking::class);
    }
}
