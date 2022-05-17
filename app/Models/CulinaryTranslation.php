<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CulinaryTranslation extends Model
{
    // use HasFactory;
    protected $table = 'culinary_translation';
    public $timestamps = false;

    public function culinary()
    {
        return $this->belongsTo(Culinary::class);
    }
}
