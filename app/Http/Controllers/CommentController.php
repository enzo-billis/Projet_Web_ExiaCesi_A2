<?php

/*! \brief The controller control and calculate every things about data.
 */

namespace App\Http\Controllers;

use App\Notifications\CommentSignaled;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Return all comments post on a picture
     * @param $id_picture
     * @return $comments
     */
    public function getComments($id_picture){
        $commentsObj = New Comment;

        //! Where add filter to the querry.
        $comments = $commentsObj->where('id_pictures','=', $id_picture)->where("ban_user_id","=",null)->orderBy('created_at','desc')->get();

        return $comments;
    }
/**
 * Allow you to add comment
 * @param $content is the content of your comment
 * @param $id_pic is the id of the picture where you want to post you comment
 * @return void
 */
    public static function addComment($content,$id_pic){

        $commentsObj = New Comment;

        //! We use eloquent create method (on the object Comment)
        //! Auth::user()->id is the id of the current user
        $commentsObj::create([
            'id_pictures' => $id_pic,
            'id_users' => Auth::user()->id,
            'comment'=>$content,
        ]);
    }

    /**
     * Allow you to delete a comment
     * @param $request content the id of comment in 'idCom' input
     * @return view->back
     */
    public function delete(Request $request){

        $commentObj = New Comment();
        //! We search the correct with idCom $comment an put it in object
        $comment = $commentObj->where('id','=',$request->input('idCom'))->first();

        //! We define the column ban_user_id for this comment. It will disable it in getComments function.
        $comment->ban_user_id = Auth::user()->id;

        //! We save the current Comment object to keep it like that
        $comment->save();

        $userObj = New User();

        //! We search all users with rank 1 (Member of BDE) and notify them of deleting with the comment object.
        $membersBDE = $userObj->where('rang',"=",1)->get();
        foreach ($membersBDE as $memberBDE){
            $memberBDE->notify(new CommentSignaled($comment));
        }

//        Comment::findOrFail($request->input('idCom'))->delete();
        return redirect()->back();
    }
}
