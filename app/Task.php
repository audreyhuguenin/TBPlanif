<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
      protected $table = 'tasks';

    public $timestamps = false;

    public function assignations()
    {
        return $this->hasMany('App\Assignation');
    }

    public function subtask()
{
    return $this->belongsTo('App\Subtask');
}

}
