<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Like;

/*
 * LikeController control every data and informations about the likes
 */
class LikeController extends Controller
{
    /*
     * Function getLikes return all likes for a picture
     * Accept one parameter : the id of the picture
     */
    public function getLikes($id_picture){
        $likeObj = New Like();
        $likes = $likeObj->where('id_pictures',"=","$id_picture")->get();
        return $likes;
    }

    /*
     * Function checkIfLike check if the user already like the picture
     * Parameter : $id_pic => the id of the picture
     * Return true or false
     */
    public static function checkIfLike($id_pic){
        if (isset(Auth::user()->id)){
            $like = New Like();
            $likeValue = $like->where('id_pictures','=',$id_pic)->where('id_users','=',Auth::user()->id)->get();
            if (!$likeValue->isEmpty()){
                return true;

            }
        }
        else{
            return false;
        }
    }
}
