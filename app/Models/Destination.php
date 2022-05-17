<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    // use HasFactory;
    protected $table = 'destination';

    public function destinationTranslation()
    {
        return $this->hasMany(DestinationTranslation::class);
    }

    public function destinationTiket()
    {
        return $this->hasMany(DestinationTiket::class);
    }

    public function destinationBooking()
    {
        return $this->hasMany(DestinationBooking::class);
    }

    public function destinationCategory()
    {
        return $this->belongsTo(DestinationCategory::class);
    }

    public function destinationOffline()
    {
        return $this->hasMany(DestinationOffline::class);
    }

    public function adminEtax()
    {
        return $this->belongsTo(AdminEtax::class);
    }
}
