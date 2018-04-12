<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function getComments($id_picture){
        $commentsObj = New Comment;
        $comments = $commentsObj->where('id_pictures','=', $id_picture)->get();
        return $comments;
    }
}
