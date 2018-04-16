<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function getComments($id_picture){
        $commentsObj = New Comment;
        $comments = $commentsObj->where('id_pictures','=', $id_picture)->orderBy('created_at','desc')->get();
        return $comments;
    }

    public static function addComment($content,$id_pic){

        $commentsObj = New Comment;
        $mytime = date('Y-m-d');
        $commentsObj::create([
            'id_pictures' => $id_pic,
            'id_users' => Auth::user()->id,
            'comment'=>$content,
        ]);
    }

    public function delete(Request $request){
        Comment::findOrFail($request->input('idCom'))->delete();
        return redirect()->back();
    }
}
