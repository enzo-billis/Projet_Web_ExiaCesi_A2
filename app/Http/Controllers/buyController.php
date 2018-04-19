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
        $user = Auth::user();
        $buyObj = New buy();
        $commands = $buyObj->where('user',"=",$user->id)->where("status","=", 0)->where('product','=',$id)->get();
//        dd($commands);
        if ($commands->isEmpty()){
            buy::create([
                'quantity' => 1,
                'user' => Auth::user()->id,
                'product' => $id,
                'status' => 0
            ]);
            return redirect()->back();
        }
        else{
//            dd( $commands);
           $quantity = $commands->first()->quantity;
           $commands->first()->quantity = $quantity+1;
           $commands->first()->save();
            return redirect()->back();
        }
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

    function validate(){
        $buyObj = New buy();
        $products = $buyObj->where('user','=',Auth::user()->id)->where('status','=',0)->get();
        foreach ($products as $product){
            $product->status = 1;
            $product->save();
        }
        return redirect()->back()->with('success', ['Bravo ! ']);
    }
}