<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pictures','id_users','comment','date_comment','ban_reason','ban_user_id',
    ];

    public function user(){
        return $this->belongsTo('App\User','id_users');
    }
}
