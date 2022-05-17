<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandcraftTranslation extends Model
{
    // use HasFactory;
    protected $table = 'handcraft_translation';
    public $timestamps = false;

    public function handcraft()
    {
        return $this->belongsTo(Handcraft::class);
    }
}
