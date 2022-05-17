<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationCategoryTranslation extends Model
{
    // use HasFactory;
    protected $table = "destination_category_translation";
    public $timestamps = false;

    public function destinationCategory()
    {
        return $this->belongsTo(DestinationCategory::class);
    }
}
