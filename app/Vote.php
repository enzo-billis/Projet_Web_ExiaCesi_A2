<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vote extends Model
{
    use Notifiable;
    protected $fillable = [
        'vote','date_vote','idea', 'user',
    ];
}
