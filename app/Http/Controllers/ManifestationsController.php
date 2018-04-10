<?php

namespace App\Http\Controllers;

use App\activitie;
use App\inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    function index($id){
        $manif = activitie::findOrFail($id);
        switch ($manif->status){
            case 0:
                $manif->status="A venir";
                break;
            case 1:
                $manif->status="En cours";
                break;
            case 2:
                $manif->status="Passé";
                break;
            case 3:
                $manif->status="Annulé";
                break;
        }
        if(isset(Auth::user()->id)){
            if (!$this->checkIfRegister(Auth::user()->id,$id)){
                return view('manifestation', compact('manif'), ['buttonStyle'=>'btn btn-primary', 'buttonText'=>"S'inscrire"]);
            }
            else{
                return view('manifestation', compact('manif'), ['buttonStyle'=>'btn btn-success', 'buttonText'=>"Déjà inscris !"]);
            }
        }
        else{
            return view('manifestation', compact('manif'), ['buttonStyle'=>'btn btn-danger', 'buttonText'=>"Connectez vous !"]);
        }

    }

//    function APIManifsFiltered($param){
//
//        $activities = New activitie();
//
//        switch ($param){
//
//            case 0:
//                //A venir
//                $manifs = $activities->where('date_add','>',date("Y-m-d"))->get();
//                break;
//            case 1:
//                //En cours
//                $manifs = $activities->where('date_add','=',date("Y-m-d"))->get();
//                break;
//            case 2:
//                //Passé
//                $manifs = $activities->where('date_add','<',date("Y-m-d"))->get();
//                break;
//            case 3:
//                //Annulé
//                $manifs = $activities->where('status','=',3)->get();
//                break;
//            case 4:
//                //Du mois
//                $manifs = $activities->where('date_add','>=',date("Y-m-01"))->where('date_add','<=',date("Y-m-t"))->get();
//                break;
//            default :
//                $manifs = $activities->all();
//        }
//
//        //return view('manifestations', compact('manifs'));
//        return response()->json($manifs);
//
//    }

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
