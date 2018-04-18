<?php
/**
 * Created by PhpStorm.
 * User: Tristan
 * Date: 18/04/2018
 * Time: 08:24
 */

namespace App\Http\Controllers;


use App\buy;

class buyController
{
    function showCart() {
        return view('buy');
    }
    function APIshowCart() {
        $buy = new buy();
        $command = $buy->all();
        return response()->json($command);
    }
    function showProductName($id) {
        $users = buy::
    }
}