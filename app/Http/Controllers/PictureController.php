<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Picture;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
//use Intervention\Image\Image;


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
        if (LikeController::checkIfLike($id)==false){
            return view('picture',compact('comments','likes'), ['picture'=>$picture,'user'=>$user,'btnStyle'=>'btn btn-primary','iconeStyle'=>'fa fa-thumbs-up fa-x2','textValue'=>'Like',]);
        }
        else{
            return view('picture',compact('comments','likes'), ['picture'=>$picture,'user'=>$user,'btnStyle'=>'btn btn-danger','iconeStyle'=>'fa fa-thumbs-down fa-x2','textValue'=>'Dislike',]);
        }



    }
    public function like($id)
    {
        $likeControl = New Like();
        if (LikeController::checkIfLike($id)==false){
            $mytime = date('Y-m-d');

            $likeControl::create([
                'id_pictures' => $id,
                'id_users' => Auth::user()->id,
                'date_like' => $mytime,
            ]);
        }
        else{
            $likeControl->where('id_pictures','=',$id)->where('id_users','=',Auth::user()->id)->delete();
        }

        return redirect()->back();

    }

    public function comment($id, Request $request){

        $content = Input::get('comment');

        $validator = Validator::make($request->all(),[
            'comment' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        CommentController::addComment($content,$id);
        return redirect()->back();
    }

    public function savePic($id, Request $request){



        $validator = Validator::make($request->all(),[
                'photo' => 'required|max:5000',
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $image = $request->file('photo');
        $filename  = time() . '.' . $image->getClientOriginalExtension();

        $path = "storage/manifestationPics/". $filename;
        $pathToDb = "manifestationPics/". $filename;


        Image::make($image->getRealPath())->fit(640, 480)->save($path);


//        $path = $request->file('photo')->store('/public/manifestationPics');
//        $path = substr($path,7);

        $pictObj = New Picture();
        $pictObj::create([
            'picture' => $pathToDb,
            'date_image' => date('Y-m-d'),
            'id_users' => Auth::user()->id,
            'id_event' => $id,
        ]);

        return redirect()->back();
    }
}
