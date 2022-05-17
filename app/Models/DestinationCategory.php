<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationCategory extends Model
{
    // use HasFactory;
    protected $table = "destination_category";

    public function destinationCategoryTranslation()
    {
        return $this->hasMany(DestinationCategoryTranslation::class);
    }

    public function destination()
    {
        return $this->hasMany(Destination::class);
    }
}
