<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPrice extends Model
{
    // use HasFactory;
    protected $table = 't_ticket_price';
    // public $timestamps = false;

    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }
}
