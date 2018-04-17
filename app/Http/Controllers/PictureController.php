<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use App\Notifications\PictureSignaled;
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
    /**
     * Function getPictures return all pictures for a manif passed with id of the manif
     * @param $id_event
     * @return Picture $pictures
     */
    public static function getPictures($id_event)
    {
        $picture = New Picture();
        $pictures = $picture->where('id_event', '=', $id_event)->get();
        return $pictures;
    }

    /**
     * Function index return the view of a picture
     * @param id of the picture to show
     * @return view('picture') with all data about picture
     */
    public function index($id)
    {
        $LikeCtl = New LikeController();
        $CommentCtl = New CommentController();

        //! We search the picture in the database
        $picture = Picture::findOrFail($id);

        //! If the picture is not ban we will show the page, else, we go back
        if ($picture->ban_reason == null) {

            //! We get likes, the author & and comments for this picture
            $comments = $CommentCtl->getComments($id);
            $likes = $LikeCtl->getLikes($id);
            $user = User::findOrFail($picture->id_users);

            //! If the user like the picture we return the view with special button style, else we return with another button style
            if (LikeController::checkIfLike($id) == false) {
                return view('picture', compact('comments', 'likes'), ['picture' => $picture, 'user' => $user, 'btnStyle' => 'btn btn-primary', 'iconeStyle' => 'fa fa-thumbs-up fa-x2', 'textValue' => 'Like',]);
            } else {
                return view('picture', compact('comments', 'likes'), ['picture' => $picture, 'user' => $user, 'btnStyle' => 'btn btn-danger', 'iconeStyle' => 'fa fa-thumbs-down fa-x2', 'textValue' => 'Dislike',]);
            }
        } else {
            return redirect()->back();
        }


    }

    /**
     * Function like add a like to the picture
     * @param id of the picture to like
     * @return redirect to back page
     */
    public function like($id)
    {
        $likeControl = New Like();

        //! We check if the user like the picture, if not we add the like
        if (LikeController::checkIfLike($id) == false) {
            $mytime = date('Y-m-d');

            $likeControl::create([
                'id_pictures' => $id,
                'id_users' => Auth::user()->id,
                'date_like' => $mytime,
            ]);
        } //! Else we delete the like.
        else {
            $likeControl->where('id_pictures', '=', $id)->where('id_users', '=', Auth::user()->id)->delete();
        }

        return redirect()->back();

    }

    /**
     * Function comment add a comment to the picture
     * @param request containing information about comment
     * @return redirect to back page
     */
    public function comment($id, Request $request)
    {

        $content = Input::get('comment');

        //! We check if the comment content match with rules
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:255',
        ]);

        //! If not we send errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //! If match we add the comment
        CommentController::addComment($content, $id);

        return redirect()->back();
    }

    /**
    * Function savePic save a picture on the storage.
    * @param id of the manifestation, content of the request.
     * @return redirect back page
    */
    public function savePic($id, Request $request)
    {
        //! Like validator above we check rules
        $validator = Validator::make($request->all(), [
            'photo' => 'required|max:5000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //! We get the image and generate a unique filename
        $image = $request->file('photo');
        $filename = time() . '.' . $image->getClientOriginalExtension();

        $path = "storage/manifestationPics/" . $filename;
        $pathToDb = "manifestationPics/" . $filename;

        //! We resize image and save it
        Image::make($image->getRealPath())->fit(640, 480)->save($path);


//        $path = $request->file('photo')->store('/public/manifestationPics');
//        $path = substr($path,7);

        //! When upload we add it to the DB
        $pictObj = New Picture();
        $pictObj::create([
            'picture' => $pathToDb,
            'id_users' => Auth::user()->id,
            'id_event' => $id,
        ]);

        return redirect()->back();
    }

    /**
    * Function delete fill the ban reason. The picture will not be show anymore
    * @param request containing information about picture
     * @return route('home')
    */
    public function delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //! We get picture and member of BDE object
        $pictureObj = New Picture();
        $picture = $pictureObj->where('id', '=', $request->input('idPic'))->first();
        $userObj = New User();
        $membersBDE = $userObj->where('rang', "=", 1)->get();

        //! We define a ban_reason for the picture & a ban id who define who ask the remove & we save
        $picture->ban_reason = $request->input('reason');
        $picture->ban_user_id = Auth::user()->id;
        $picture->save();

        //! We notify all member of the ban
        foreach ($membersBDE as $memberBDE) {
            $memberBDE->notify(new PictureSignaled($picture));
        }

        return redirect()->route('home');
    }

    /**
    * Function downloadZip send a zip file to the browser containing all picture of an manifestation
    * @param request containing information about manifestation
     * @return Zip File to download
    */
    public function downloadZip(Request $request)
    {

        $pictureObj = new Picture();

        //! We get all pictures about this manif
        $pictures = $pictureObj->where('id_event', '=', $request->input('idManif'))->get();

        //! If there is picture we create the file else we return back with error
        if (isset($pictures->first()->id)) {

            //! We create a zip file with unique name
            $zip = new ZipArchive();
            $filename = date('Y-m-d-H-m-s') . "-" . $request->input('name') . ".zip";

            //! Check if the creation containing error
            if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
                exit("Impossible d'ouvrir le fichier <$filename>\n");
            }

            //! We add each pictures in the zip file
            $i = 1;
            foreach ($pictures as $picture) {
                $i++;
                $zip->addFile("storage/" . $picture->picture);
//            dd($zip->addFile("storage/".$picture->picture));
            }

            echo "Statut :" . $zip->status . "\n";

            //! We close the zip file and download it. We delete it after download (Optimize space)
            $zip->close();

            return response()->download($filename)->deleteFileAfterSend(true);
        }

        return Redirect::back()->withErrors(['Aucune photo !']);
    }
}
