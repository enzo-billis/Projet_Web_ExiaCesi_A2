<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\activitie;
use App\inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManifestationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        if (!$this->checkIfRegister(Auth::user()->id,$id)){
            return view('manifestation', compact('manif'), ['buttonStyle'=>'btn btn-primary', 'buttonText'=>"S'inscrire"]);
        }
        else{
            return view('manifestation', compact('manif'), ['buttonStyle'=>'btn btn-success', 'buttonText'=>"Déjà inscris !"]);
        }
        //return view('manifestation', compact('manif'));
    }

    function registration($id){
        if (!$this->checkIfRegister(Auth::user()->id,$id)){
            $mytime = date('Y-m-d H:i:s');
            inscription::create([
                'activity'=>$id,
                'user'=>Auth::user()->id,
                'date'=>$mytime,
            ]);
        }
        else{

        }
        
        return redirect()->route('manif', ['id' => $id]);
    }

    function checkIfRegister($user,$manif){
       if(inscription::where(['activity' => $manif, 'user' => $user])->first()){
           return true;
       }
       else{
           return false;
       }
    }
}
