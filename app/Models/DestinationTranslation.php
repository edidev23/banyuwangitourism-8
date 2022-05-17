<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationTranslation extends Model
{
    // use HasFactory;
    protected $table = 'destination_translation';
    public $timestamps = false;

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
