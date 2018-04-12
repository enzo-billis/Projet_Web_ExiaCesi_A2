<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function getComments($id_picture){
        $commentsObj = New Comment;
        $comments = $commentsObj->where('id_pictures','=', $id_picture)->orderBy('date_comment','desc')->get();
        return $comments;
    }

    public static function addComment($content,$id_pic){
        $commentsObj = New Comment;
        $mytime = date('Y-m-d');
        $commentsObj::create([
            'id_pictures' => $id_pic,
            'id_users' => Auth::user()->id,
            'comment'=>$content,
            'date_comment' => $mytime,
        ]);
    }
}
