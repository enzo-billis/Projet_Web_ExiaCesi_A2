<?php

namespace App\Http\Controllers;

use App\inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
 * InscriptionController control every informations and data about inscription (to a manifestation) object.
 */
class InscriptionController extends Controller
{

    /**
     * Allow usage of function only if the actual user is connected
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

   /**
    * This function register a user for a manifestation.
    * @param $Id of the manifestation
    * @return nothing
    */
    function registration($id){
        /*
        * If user is not register we create a new line into the DB
        * We use checkIfRegister method for this. With parameter user Id
        */
        if (!$this->checkIfRegister(Auth::user()->id,$id)){
            $mytime = date('Y-m-d H:i:s');
            inscription::create([
                'activity'=>$id,
                'user'=>Auth::user()->id,
                'date'=>$mytime,
            ]);
        }
        //! If user is already register we delete it from the DB
        else{
            $inscriptionToDelete=inscription::where(['activity' => $id, 'user' => Auth::user()->id]);
            $inscriptionToDelete->delete();
        }
        //! We redirect to the manifestation page
        return redirect()->route('manif', ['id' => $id]);
    }
/**
 * Check if the user is register for this manif
 * @param $user => Id of the user
 * @param $manif => Id of the manif
 * @return true or false
 */

    function checkIfRegister($user,$manif){
        if(inscription::where(['activity' => $manif, 'user' => $user])->first()){
            return true;
        }
        else{
            return false;
        }
    }
    function APIIndex() {
        return inscription::all();
    }
    function APIShow($id) {
        return inscription::find($id);
    }
}
