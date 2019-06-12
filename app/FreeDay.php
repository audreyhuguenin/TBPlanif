<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeDay extends Model
{
   protected $table = 'free_days';

   protected $fillable = [
        'startDate',
        'endDate',
    ];

    public $timestamps = false;

    public function user()
{
    return $this->belongsTo('App\User');
}
}
