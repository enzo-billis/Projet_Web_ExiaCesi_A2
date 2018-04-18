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
        $command = $buy->all();
        return response()->json($command);
    }
    function showProductName($id) {
    }
}