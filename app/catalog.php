<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class catalog extends Model
{
    use Notifiable;
    protected $fillable = [
        'name','description','image','price','category'
    ];

    public function buy(){
        return $this->hasMany('App\buy');
    }

}
