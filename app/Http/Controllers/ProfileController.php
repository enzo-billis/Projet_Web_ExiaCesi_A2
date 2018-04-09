<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index($id){
        $user = User::findOrFail($id);
        return view('profile', compact('user'));
    }
    function UserConnected(){
        $user = Auth::user();
        return view('profile', compact('user'));
    }
}
