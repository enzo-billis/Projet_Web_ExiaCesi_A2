<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function getLikes($id_picture){
        $likeObj = New Like();
        $likes = $likeObj->where('id_pictures',"=","$id_picture")->get();
        return $likes;
    }

    public static function checkIfLike($id_pic){
        $like = New Like();
        $likeValue = $like->where('id_pictures','=',$id_pic)->where('id_users','=',Auth::user()->id)->get();
        if (!$likeValue->isEmpty()){
            return true;

        }
        else{
            return false;
        }
    }
}
