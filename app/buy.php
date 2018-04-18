<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class buy extends Model
{
    use Notifiable;
    protected $fillable = [
        'quantity', 'user', 'product', 'status'
    ];
}
