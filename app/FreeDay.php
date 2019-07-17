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
    protected $casts = [
        'startDate' => 'datetime',
        'endDate' => 'datetime',
    ];
    public $timestamps = false;

    /**
     * Permet de récupérer l'utilisateur auqeul le jour de congé est assigné
     */
    public function user()
{
    return $this->belongsTo('App\User');
}
}
