<?php

namespace App\Http\Controllers;

use App\Notifications\CommentSignaled;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function getComments($id_picture){
        $commentsObj = New Comment;
        $comments = $commentsObj->where('id_pictures','=', $id_picture)->where("ban_user_id","=",null)->orderBy('created_at','desc')->get();
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

        $commentObj = New Comment();
        $comment = $commentObj->where('id','=',$request->input('idCom'))->first();
        $comment->ban_user_id = Auth::user()->id;
        $comment->save();
//        dd($comment);

        $userObj = New User();
        $membersBDE = $userObj->where('rang',"=",1)->get();
        foreach ($membersBDE as $memberBDE){
            $memberBDE->notify(new CommentSignaled($comment));
        }

//        Comment::findOrFail($request->input('idCom'))->delete();
        return redirect()->back();
    }
}
