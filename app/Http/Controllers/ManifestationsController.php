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

//        switch ($manif->date_add) {
//            case 0:
//                $manif->status = "A venir";
//                break;
//            case 1:
//                $manif->status = "En cours";
//                break;
//            case 2:
//                $manif->status = "Passé";
//                break;
//            case 3:
//                $manif->status = "Annulé";
//                break;
//        }

        if ($manif->date_add > date('Y-m-d')){
            $manif->status = "A venir";
        }
        if ($manif->date_add < date('Y-m-d')){
            $manif->status = "Passé";
        }
        if ($manif->date_add == date('Y-m-d')){
            $manif->status = "En cours";
        }
        if ($manif->status == 3){
            $manif->status = "Annulé";
        }

        if (isset(Auth::user()->id)) {
            if (!$this->checkIfRegister(Auth::user()->id, $id)) {
                return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-primary', 'buttonText' => "S'inscrire", 'numberPicture' => count($pictures)]);
            } else {
                return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Se désinscrire", 'numberPicture' => count($pictures)]);
            }
        } else {
            return view('manifestation', compact('manif','pictures'), ['buttonStyle' => 'btn btn-danger', 'buttonText' => "Connectez vous !", 'numberPicture' => count($pictures)]);
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
