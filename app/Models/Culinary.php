<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Culinary extends Model
{
    // use HasFactory;
    protected $table = 'culinary';

    public function culinaryTranslation()
    {
        return $this->hasMany(CulinaryTranslation::class);
    }
}
