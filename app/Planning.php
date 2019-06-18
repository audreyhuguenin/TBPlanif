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

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function projects()
    {
        return $this->belongsToMany('App\Project', 'planning_project');
    }

    public function globalPlanning()
    {
        return $this->belongsTo('App\Planning', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Planning', 'parent_id');
    }

}
