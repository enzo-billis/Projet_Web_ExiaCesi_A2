<?php

namespace App\Http\Controllers;

use App\inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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
            $inscriptionToDelete=inscription::where(['activity' => $id, 'user' => Auth::user()->id]);
            $inscriptionToDelete->delete();
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
