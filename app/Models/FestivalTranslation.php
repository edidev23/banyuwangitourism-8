<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FestivalTranslation extends Model
{
    // use HasFactory;
    protected $table = 'festival_translation';
    public $timestamps = false;

    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }
}
