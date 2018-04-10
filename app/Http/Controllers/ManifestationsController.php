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
        if(inscription::where(['activity' => $manif, 'user' => $user])->first()){
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
    function allManif(){
        $manifs = activitie::all();
            return view('manifestations', compact('manifs'));

    }
    function ManifsFiltered($status){
        if ($status == 5){
            $manifs = activitie::where('date_add','>=',date("Y-m-01"))->where('date_add','<=',date("Y-m-t"))->get();
        }
        else if ($status == 4){
            $manifs = activitie::all();
        }
        else if ($status == 0){
            $manifs = activitie::where('date_add','<',date("Y-m-d"))->get();
        }
        else if ($status == 1){
            $manifs = activitie::where('date_add','>',date("Y-m-d"))->get();
        }
        else {
            $manifs = activitie::where(['status' => $status])->get();
        }
        return view('manifestations', compact('manifs'));

    }


}
