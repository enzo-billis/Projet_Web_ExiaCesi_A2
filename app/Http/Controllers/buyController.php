<?php
/**
 * Created by PhpStorm.
 * User: Tristan
 * Date: 18/04/2018
 * Time: 08:24
 */

namespace App\Http\Controllers;


use App\buy;
use App\Http\Requests\catalog;
use Auth;

use Auth;
use Illuminate\Support\Facades\DB;

class buyController
{
    /**
     * Access to the Cart page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function showCart() {
        $user = Auth::user();
        $buyObj = New buy();
        $commands = $buyObj->where('user',"=",$user->id)->where("status","=", 0)->get();
        return view('buy', compact('commands'));
    }

    function addtoCart($id){
        $product = $id;
        if (buy::findOrFail($product)) {
            DB::table('buys')->where('product','=',$product)->increment('quantity',1);
        } else {
            buy::create([
                'quantity' => 1,
                'user' => $user->id,
                'status' => 0,
                'product' => $id
            ]);
        }
        return redirect()->route('shopList');
    }

    function addtoCart($id){
        buy::create([
          'quantity' => 1,
          'user' => Auth::user()->id,
          'product' => $id,
          'status' => 0
        ]);
        return redirect()->back();
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

    /**
     * API used for show historic
     * @return \Illuminate\Http\JsonResponse
     */
    function APIshowHistoric() {
        $buy = new buy();
        $historic = $buy->all();//where('status','=',2);
        return response()->json($historic);
    }
    function showProductName($product) {
        DB::table('buy')->join('catalogs','buy.'.$product,'=','catalogs.id')->select('catalogs.name')->get();
    }
}