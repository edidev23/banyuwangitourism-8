<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handcraft extends Model
{
    // use HasFactory;
    protected $table = 'handcraft';

    public function handcraftTranslation()
    {
        return $this->hasMany(HandcraftTranslation::class);
    }
}
