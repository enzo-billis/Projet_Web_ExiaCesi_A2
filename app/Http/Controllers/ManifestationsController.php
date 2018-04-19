<?php

namespace App\Http\Controllers;

use App\activitie;
use App\Idea;
use App\Manifestation;
use App\inscription;
use App\Notifications\IdeaSelected;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PictureController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class ManifestationsController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Function checkIfRegister check if the user already register for this manif
     * @param $user,$manif
     * @return true or false
     */
    function checkIfRegister($user, $manif)
    {
        $inscriptions = New inscription();
        if ($inscriptions->where(['activity' => $manif, 'user' => $user])->first()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get manifestation object with all data from DB
     * @param $id
     * @return view('manifestation')
     */
    function index($id)
    {
        //! We define instanciate an object and we put inside all data of the manifestation from the DB
        $pictureController = New PictureController();
        $manif = activitie::findOrFail($id);

        //! We get all pictures for this manifestation
        $pictures = $pictureController->getPictures($id);

        //! We define status of the manifestation with the date_add (Date of the manif)
        if ($manif->status == 3) {
            $manif->status = "Annulé";
            $manif->date_add = "2099-12-30";
        }

        if ($manif->date_add > date('Y-m-d') && $manif->date_add !== "2099-12-30") {
            $manif->status = "A venir";
        }
        if ($manif->date_add < date('Y-m-d')) {
            $manif->status = "Passé";

        }
        if ($manif->date_add == date('Y-m-d')) {
            $manif->status = "En cours";
        }

//! If the user is connected
        if (isset(Auth::user()->id)) {
            $inscriptionObj = New inscription();
            $register = $inscriptionObj->where('user','=',Auth::user()->id)->where('activity','=',$id)->get();
//            dd($register);
            //! && the manifestation passed
            if ($manif->status === "Passé" && !$register->isEmpty()) {

                //! we return the view manifestation with some style and data
                return view('manifestation', compact('manif', 'pictures', 'inscrits'), ['buttonStyle' => 'btn btn-success', 'buttonText' => "Partagez vos photos", 'numberPicture' => count($pictures), 'modal' => true]);

            }
            elseif ($manif->status === "Passé" && $register->isEmpty()){
                return view('manifestation', compact('manif', 'pictures', 'inscrits'), ['buttonStyle' => 'btn btn-success', 'buttonText' => "Vous n'étiez pas inscrit.", 'numberPicture' => count($pictures), 'modal' => false]);

            }

            //! && the manifestation annuled
            if ($manif->status === "Annulé") {
                //! we return the view manifestation with some style and data
                return view('manifestation', compact('manif', 'pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Annulé", 'numberPicture' => count($pictures), 'route' => "/home"]);
            } //! && the manifestation is to come
            else {

                //! && user is not register
                if (!$this->checkIfRegister(Auth::user()->id, $id)) {


                    $inscrits = $manif->users;

                    return view('manifestation', compact('manif', 'pictures'), ['buttonStyle' => 'btn btn-primary', 'buttonText' => "S'inscrire", 'numberPicture' => count($pictures), 'route' => route('registerManif', $manif->id), 'inscrits' => $inscrits]);
                } //! && user is already register
                else {

                    $inscrits = $manif->users;
                    return view('manifestation', compact('manif', 'pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Se désinscrire", 'numberPicture' => count($pictures), 'route' => route('registerManif', $manif->id), 'inscrits' => $inscrits]);
                }
            }

        } //!if user is not auth
        else {
            return view('manifestation', compact('manif', 'pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Connectez vous !", 'numberPicture' => count($pictures), 'route' => route('registerManif', $manif->id)]);
        }

    }

    /**
        * Return all manifestations
        * @return view('manifestations')
        */
    function allManif()
    {
        $manifObj = new activitie();
        $manifs = $manifObj->latest('created_at')->get();
        return view('manifestations', compact('manifs'));

    }

    /**
        * API : return a manifestation in JSON Format
        * @param $IdManifestation
        * @return json($Manifestation)
        */
    function APIManifFiltered($param)
    {

        $activities = New activitie();

        $manif = $activities->where('id', '=', $param)->get();

        return response()->json($manif);

    }

    /**
       * API return all manifestations
       * @return json($Manifestations)
       */
    function APIManifs()
    {

        $manifObj = new activitie();
        $manifs = $manifObj->latest('created_at')->get();

        return response()->json($manifs);

    }

    function APIIndex() {
        return Manifestation::all();
    }

    /**
       * Create a new manifestation
       * @param $request a request containing name,description,picture,recurrence,date and price.
       */
    function newManif(Request $request)
    {
        //!If the request contain a vote input mean it's come from and Idea and should be change to a real manifestation
        if ($request->input('vote')) {

            //!If the input vote is yes we will change the picture for the idea
            if ($request->input('vote') === "yes") {

                //!We check content of the request to validate it
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:5000',
                    'description' => 'required|string|max:5000',
                    'photo' => 'required|max:5000',
                    'recurrence' => 'required|string|max:5000',
                    'date' => 'required',
                    'price' => 'required',
                ]);

                //!If validation doesn't match we return errors
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                //!We define the object image & a unique file name
                $image = $request->file('photo');
                $filename = time() . '.' . $image->getClientOriginalExtension();

                //!There is two path because this is relative path and not the same for saving image and printing it from DB
                $path = "storage/manifestationCoverPics/" . $filename;
                $pathToDb = "/storage/manifestationCoverPics/" . $filename;

                //!We resize & save the picture
                Image::make($image->getRealPath())->fit(400, 280)->save($path);
            } //!If no we let the old image
            else {
                $pathToDb = $request->input('oldPhoto');
            }

            //!We search the idea matching with the ID come from the form
            $idea = Idea::find($request->input('id'));
            //!We delete it
            $idea->delete();
            //!We notify the user who propose the idea
            User::find($request->input('author'))->notify(new IdeaSelected($idea));

        } else {

            //!Same as above
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:5000',
                'description' => 'required|string|max:5000',
                'photo' => 'required|max:5000',
                'recurrence' => 'required|string|max:5000',
                'date' => 'required',
                'price' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $path = "storage/manifestationCoverPics/" . $filename;
            $pathToDb = "/storage/manifestationCoverPics/" . $filename;


            Image::make($image->getRealPath())->fit(400, 280)->save($path);
        }
//        $path = $request->file('photo')->store('/public/manifestationPics');
//        $path = substr($path,7);

        //!We create the new line in the DB for this new manifestation with all input informations
        $manifObj = New activitie();
        $manifObj::create([
            'name' => $request->input('name'),
            'image' => $pathToDb,
            'description' => $request->input('description'),
            'status' => 0,
            'recurrence' => $request->input('recurrence'),
            'date_add' => $request->input('date'),
            'month_activity' => 0,
            'price' => $request->input('price'),
        ]);

        //!We get the last manifestation in the databse (The one we just created) & redirect user to this page
        $idLast = $manifObj->orderBy('created_at', 'desc')->first();
        return redirect()->route('manif', $idLast->id);

    }
}
