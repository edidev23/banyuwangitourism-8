<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationOffline extends Model
{
    // use HasFactory;
    protected $table = 'destination_offline';

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
