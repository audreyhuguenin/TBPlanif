<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
 protected $table = 'plannings';
 protected $fillable = [
        'sent'
    ];



    public $timestamps = false;
}
