<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Check if user is auth
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Return the profile view with all informations about the user who have this ID
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index($id){
        $user = User::findOrFail($id);
        return view('profile', compact('user'));
    }
    /**
     * Return the profile view with all informations about the actual user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function UserConnected(){
        $user = Auth::user();
        return view('profile', compact('user'));
    }
}
