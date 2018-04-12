<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Picture;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

class PictureController extends Controller
{
    public static function getPictures($id_event){
        $picture = New Picture();
        $pictures= $picture->where('id_event','=',$id_event)->get();
        return $pictures;
    }
    public function index($id){
        $LikeCtl = New LikeController();
        $CommentCtl = New CommentController();


        $picture = Picture::findOrFail($id);
        $comments = $CommentCtl->getComments($id);

        $likes = $LikeCtl->getLikes($id);
        $user = User::findOrFail($picture->id_users);
        return view('picture',compact('comments','likes'), ['picture'=>$picture,'user'=>$user]);


    }
}
