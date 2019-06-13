<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
      protected $table = 'tasks';
      protected $fillable = [
        'name',
        'comment'
    ];

    public $timestamps = false;

    public function plannings()
    {
        return $this->hasMany('App\Assignation');
    }
    public function subtask()
{
    return $this->belongsTo('App\Subtask');
}

}
