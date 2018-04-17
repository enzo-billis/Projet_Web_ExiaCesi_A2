<?php

/*! \brief The controller comment control and calculate every things about comments.
 *
 *
 *  This controller you can get the comments, add comment and delete one.
 */

namespace App\Http\Controllers;

use App\Notifications\CommentSignaled;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    /*
     * Give one parameter => Id of the picture
     * Return => Object with all comments associate
     */
    public function getComments($id_picture){
        $commentsObj = New Comment;

        //Where add filter to the querry.
        $comments = $commentsObj->where('id_pictures','=', $id_picture)->where("ban_user_id","=",null)->orderBy('created_at','desc')->get();

        return $comments;
    }
/*
 * Add comment function allow you to add comment
 * Parameters : $content is the content of your comment, $id_pic is the id of the picture where you want to post you comment
 * Return nothing
 */
    public static function addComment($content,$id_pic){

        $commentsObj = New Comment;

        //We use eloquent create method (on the object Comment)
        //Auth::user()->id is the id of the current user
        $commentsObj::create([
            'id_pictures' => $id_pic,
            'id_users' => Auth::user()->id,
            'comment'=>$content,
        ]);
    }

    /*
     * delete function allow you to delete a comment
     * $request is the input. It should content the id of comment in 'idCom' input
     */
    public function delete(Request $request){

        $commentObj = New Comment();
        //We search the correct with idCom $comment an put it in object
        $comment = $commentObj->where('id','=',$request->input('idCom'))->first();

        //We define the column ban_user_id for this comment. It will disable it in getComments function.
        $comment->ban_user_id = Auth::user()->id;

        //We save the current Comment object to keep it like that
        $comment->save();

        $userObj = New User();

        //We search all users with rank 1 (Member of BDE) and notify them of deleting with the comment object.
        $membersBDE = $userObj->where('rang',"=",1)->get();
        foreach ($membersBDE as $memberBDE){
            $memberBDE->notify(new CommentSignaled($comment));
        }

//        Comment::findOrFail($request->input('idCom'))->delete();
        return redirect()->back();
    }
}
