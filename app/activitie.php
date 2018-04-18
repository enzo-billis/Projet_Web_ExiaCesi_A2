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

    //Function use for relation has many to user attributs
    public function picture(){
        return $this->hasMany('App\Picture');
    }

    //Function use for relation belongsToMany to
    public function users(){
        return $this->belongsToMany('App\User','inscriptions','activity','user')->as('users')->withPivot('date');
    }
}
