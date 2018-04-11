<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Idea extends Model
{
    use Notifiable;
    protected $fillable = [
        'name','description','image', 'user',
    ];
}
