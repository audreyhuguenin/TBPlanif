<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignation extends Model
{
 protected $table = 'assignations';

  protected $fillable = [
      'date',
      'duration',
      'type',
      'suiviDA',
      'unmovable'
    ];


    public $timestamps = false;
}
