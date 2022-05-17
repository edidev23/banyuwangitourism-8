<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminEtax extends Model
{
    // use HasFactory;
    protected $table = 'admin_etax';

    public function destination()
    {
        return $this->hasMany(Destination::class);
    }
}
