<?php

namespace App\Http\Controllers;

use App\activitie;
use App\inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PictureController;

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
                return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-success', 'buttonText' => "Partagez vos photos", 'numberPicture' => count($pictures), 'modal'=>true]);

            }
            if ($manif->status === "Annulé"){
                return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Annulé", 'numberPicture' => count($pictures), 'route' => "/home"]);
            }
            else{
                if (!$this->checkIfRegister(Auth::user()->id, $id)) {
                    return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-primary', 'buttonText' => "S'inscrire", 'numberPicture' => count($pictures) , 'route' => route('registerManif', $manif->id)]);
                } else {
                    return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Se désinscrire", 'numberPicture' => count($pictures), 'route' => route('registerManif', $manif->id)]);
                }
            }

            }
        else {
            return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Connectez vous !", 'numberPicture' => count($pictures), 'route' => route('login')]);
        }

    }

    function allManif(){
        $manifs = activitie::all();
        return view('manifestations', compact('manifs'));

    }
    function APIManifFiltered($param){

        $activities = New activitie();

        $manif = $activities->where('id','=',$param)->get();

        return response()->json($manif);

    }
    function APIManifs(){

        $activities = New activitie();

        $manifs = $activities->all();

        return response()->json($manifs);

    }
}
