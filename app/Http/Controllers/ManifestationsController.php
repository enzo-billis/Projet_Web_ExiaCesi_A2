<?php

namespace App\Http\Controllers;

use App\activitie;
use App\inscription;
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

    function checkIfRegister($user,$manif){
        $inscriptions = New inscription();
        if($inscriptions->where(['activity' => $manif, 'user' => $user])->first()){
            return true;
        }
        else{
            return false;
        }
    }

    function index($id)
    {
        $pictureController = New PictureController();
        $manif = activitie::findOrFail($id);
        $pictures = $pictureController->getPictures($id);

        if ($manif->status == 3){
            $manif->status = "Annulé";
            $manif->date_add = "2099-12-30";
        }

        if ($manif->date_add > date('Y-m-d') && $manif->date_add!=="2099-12-30"){
            $manif->status = "A venir";
        }
        if ($manif->date_add < date('Y-m-d')){
            $manif->status = "Passé";

        }
        if ($manif->date_add == date('Y-m-d')){
            $manif->status = "En cours";
        }



        if (isset(Auth::user()->id)) {
            if ($manif->status === "Passé"){

                return view('manifestation', compact('manif','pictures','inscrits'), ['buttonStyle' => 'btn btn-success', 'buttonText' => "Partagez vos photos", 'numberPicture' => count($pictures), 'modal'=>true]);

            }
            if ($manif->status === "Annulé"){
                return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Annulé", 'numberPicture' => count($pictures), 'route' => "/home"]);
            }
            else{
                if (!$this->checkIfRegister(Auth::user()->id, $id)) {
                    $inscrits=$manif->users;
                    return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-primary', 'buttonText' => "S'inscrire", 'numberPicture' => count($pictures) , 'route' => route('registerManif', $manif->id),'inscrits'=>$inscrits]);
                } else {
                    $inscrits=$manif->users;
                    return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Se désinscrire", 'numberPicture' => count($pictures), 'route' => route('registerManif', $manif->id),'inscrits'=>$inscrits]);
                }
            }

            }
        else {
            return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Connectez vous !", 'numberPicture' => count($pictures), 'route' => route('registerManif', $manif->id)]);
        }

    }

    function allManif(){
        $manifObj = new activitie();
        $manifs = $manifObj->latest('created_at')->get();
        return view('manifestations', compact('manifs'));

    }
    function APIManifFiltered($param){

        $activities = New activitie();

        $manif = $activities->where('id','=',$param)->get();

        return response()->json($manif);

    }
    function APIManifs(){

        $manifObj = new activitie();
        $manifs = $manifObj->latest('created_at')->get();

        return response()->json($manifs);

    }

    function newManif(Request $request){

        $validator = Validator::make($request->all(),[
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
        $filename  = time() . '.' . $image->getClientOriginalExtension();

        $path = "storage/manifestationCoverPics/". $filename;
        $pathToDb = "manifestationCoverPics/". $filename;


        Image::make($image->getRealPath())->fit(400, 280)->save($path);


//        $path = $request->file('photo')->store('/public/manifestationPics');
//        $path = substr($path,7);

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

        return redirect()->back()->with('success', ['Bravo ! ']);

    }
}
