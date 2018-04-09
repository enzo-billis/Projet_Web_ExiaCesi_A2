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
        return view('manifestation', compact('manif'));
    }
}
