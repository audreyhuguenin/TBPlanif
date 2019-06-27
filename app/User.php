<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use Notifiable;
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'initials', 'contractRate',
    ];

    public $sortable = ['name', 'email', 'initials'];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function assignations()
    {
        return $this->hasMany('App\Assignation');
    }
    
    public function freeDays()
    {
        return $this->hasMany('App\FreeDay', 'user_id');
    }

    public function plannings()
    {
        return $this->hasMany('App\Planning');
    }


public function recurrentFreeDays()
{
    return $this->belongsToMany('App\RecurrentFreeDay', 'recurrent_free_days_user', 'user_id', 'recurrent_free_days_id');
}

public function skills()
{
    return $this->belongsToMany('App\Skill', 'skill_user');
}

}
