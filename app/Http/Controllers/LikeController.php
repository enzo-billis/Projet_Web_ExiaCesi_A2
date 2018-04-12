<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function getLikes($id_picture){
        $likeObj = New Like();
        $likes = $likeObj->where('id_pictures',"=","$id_picture")->get();
        return $likes;
    }
}
