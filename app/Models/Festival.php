<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    // use HasFactory;
    protected $table = 'festival';

    public function festivalTranslation()
    {
        return $this->hasMany(FestivalTranslation::class);
    }

    public function ticketPrice()
    {
        return $this->hasMany(TicketPrice::class);
    }
}
