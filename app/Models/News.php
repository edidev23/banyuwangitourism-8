<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    // use HasFactory;
    protected $table = 'news';

    public function newsTranslation()
    {
        return $this->hasMany(NewsTranslation::class);
    }
}
