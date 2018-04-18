<?php
/**
 * Created by PhpStorm.
 * User: Tristan
 * Date: 18/04/2018
 * Time: 08:24
 */

namespace App\Http\Controllers;


use App\buy;
use App\catalog;

use Illuminate\Support\Facades\DB;

class buyController
{
    /**
     * Access to the Cart page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function showCart() {

        return view('buy');
    }

    /**
     * API used for show all command
     * @return \Illuminate\Http\JsonResponse
     */
    function APIshowCart() {
        $buy = new buy();
        $command = $buy->where('status','=',1);
        return response()->json($command);
    }
    function APIshowHistoric() {
        $buy = new buy();
        $historic = $buy->all();//where('status','=',2);
        return response()->json($historic);
    }
    function showProductName($product) {
        DB::table('buy')->join('catalogs','buy.'.$product,'=','catalogs.id')->select('catalogs.name')->get();
    }
}