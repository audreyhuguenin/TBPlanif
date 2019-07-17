<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecurrentFreeDay extends Model
{
     protected $table = 'recurrent_free_days';

    public $timestamps = false;

    /**
     * Permet de récupérer tous les utilisateurs qui ont ce jour ce congé récurrent
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'recurrent_free_days_user', 'recurrent_free_days_id', 'user_id');
    }
}
