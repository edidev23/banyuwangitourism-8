<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationTiket extends Model
{
    // use HasFactory;
    protected $table = 'destination_ticket';

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
