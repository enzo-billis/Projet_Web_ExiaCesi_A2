<?php

namespace App\Http\Controllers;

use App\activitie;
use App\Manifestation;
use Illuminate\Http\Request;

class ManifestationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index($id){
        $manif = activitie::findOrFail($id);
        return view('manifestation', compact('manif'));
    }
}
