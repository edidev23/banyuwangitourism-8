<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
    // use HasFactory;
    protected $table = 'news_translation';
    public $timestamps = false;

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
