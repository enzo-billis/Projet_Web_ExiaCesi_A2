<?php

namespace App\Http\Controllers;

use App\User;

class userController extends Controller
{
    function APIIndex(){
        return User::all();
    }
    function APIShow($id){
        return User::find($id);
    }
}
