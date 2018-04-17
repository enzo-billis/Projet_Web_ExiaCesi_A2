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

    //Middleware auth allow usage of function only if the actual user is connected
    public function __construct()
    {
        $this->middleware('auth');
    }

   /*
    * This function register a user for a manifestation.
    * Accept on param => Id of the manifestation
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
        //If user is already register we delete it from the DB
        else{
            $inscriptionToDelete=inscription::where(['activity' => $id, 'user' => Auth::user()->id]);
            $inscriptionToDelete->delete();
        }
        //We redirect to the manifestation page
        return redirect()->route('manif', ['id' => $id]);
    }
/*
 * Function register return true or false
 * Check if the user is register for this manif
 * Parameters :
 * $user => Id of the user
 * $manif => Id of the manif
 * CHeck into the table inscription (from DB)
 */

    function checkIfRegister($user,$manif){
        if(inscription::where(['activity' => $manif, 'user' => $user])->first()){
            return true;
        }
        else{
            return false;
        }
    }
}
