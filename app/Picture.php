<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Picture extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'picture','id_users','id_event','ban_reason','ban_user_id',
    ];

    public function activite(){
        return $this->belongsTo('App\activitie','id_event');
    }
}
