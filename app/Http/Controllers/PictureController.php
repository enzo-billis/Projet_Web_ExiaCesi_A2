<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use App\User;
use Auth;
use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use App\Picture;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use ZipArchive;

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
        return Response::download('storage/manifestationCoverPics/1523820280.jpg');
//        return redirect()->back();
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

    public function delete(Request $request){
        Picture::findOrFail($request->input('idPic'))->delete();
        $CommentObj = New Comment();
        $CommentObj->where('id_pictures',"=",$request->input('idPic'))->delete();
        return redirect()->route('manifs');
    }

    public function downloadZip(Request $request){

        $pictureObj = new Picture();

        $pictures = $pictureObj->where('id_event','=',$request->input('idManif'))->get();

        if(isset($pictures->first()->id)){

        $zip = new ZipArchive();
        $filename = date('Y-m-d-H-m-s')."-".$request->input('name').".zip";

        if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
            exit("Impossible d'ouvrir le fichier <$filename>\n");
        }

        $i=1;
        foreach ($pictures as $picture){
            $i++;
            $zip->addFile("storage/".$picture->picture);
//            dd($zip->addFile("storage/".$picture->picture));
        }

        echo "Statut :" . $zip->status . "\n";

        $zip->close();

        return response()->download($filename)->deleteFileAfterSend(true);
        }

        return Redirect::back()->withErrors(['Aucune photo !']);
    }
}
