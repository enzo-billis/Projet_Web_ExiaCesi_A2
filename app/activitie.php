<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class activitie extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','image','description', 'date_add', 'price','month_activity', 'recurrence','status'
    ];

    public function picture(){
        return $this->hasMany('App\Picture');
    }

    public function users(){
        return $this->belongsToMany('App\User','inscriptions','activity','user')->as('users')->withPivot('date');
    }
}
