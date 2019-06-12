<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecurrentFreeDay extends Model
{
     protected $table = 'recurrent_free_days';

    public $timestamps = false;

    public function users()
{
    return $this->belongsToMany('App\User', 'recurrent_free_days_user', 'recurrent_free_days_id', 'user_id');
}
}
