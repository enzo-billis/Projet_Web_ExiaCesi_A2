<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Picture;

class PictureController extends Controller
{
    public static function getPictures($id_event){
        $picture = New Picture();
        $pictures= $picture->where('id_event','=',$id_event)->get();
        return $pictures;
    }
}
