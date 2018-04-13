<?php
/**
 * Created by PhpStorm.
 * User: Tristan
 * Date: 11/04/2018
 * Time: 15:27
 */

namespace App\Http\Controllers;


use App\catalog;
use Illuminate\Http\Request;
use App\Http\Requests;

class catalogController extends Controller
{
    public function __construct()
    {
    }

    function findProduct($name)
    {
        return catalog::where(['name' => $name]);
    }
    function addProduct()
    {
        return view('newProduct', compact('newProduct'));
    }
    function PostAddProduct(Request $request)
    {
  //      dd($request);
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $image = function($request) {
            $this->validate($request, [ 'image' => 'required|image|mimes:jpeg,png,gif,svg|max:1024',]);
            $imageName = $request->image->getClientOriginalExtention();
            $request->image->move(public_path('images'),$imageName);
            return $imageName;
    };
        $category = $request->input('category');

                catalog::create([
                    'name'=>$name,
                    'description'=>$description,
                    'price'=>$price,
                    'image'=>$image,
                    'category'=>$category,
                ]);
            return $this->showCatalog();
    }
    function editProduct($id, $name, $description, $price, $image, $category)
    {
        catalog::findOrFail($id)->update(['name'=>$name,'description'=>$description,'price'=>$price,'image'=>$image,'category',$category]);
        return redirect()->route('shop');
    }
    function removeProduct($name)
    {
       $deletedProduct = catalog::where(['name' => $name]);
       $deletedProduct->delete();
       return $this->showCatalog();
    }
    function showCatalog() {
        $catalogs = catalog::all();
        return view('shop', compact('catalogs'));
    }
    function APIShowByCategory($category){

    }
    function APICatalog() {
        $catalog = New catalog();

        $shop = $catalog->all();

        return response()->json($shop);
    }

    function postImage($request) {
        $this->validate($request, [ 'image' => 'required|image|mimes:jpeg,png,gif,svg|max:1024',]);
        $imageName = $request->image->getClientOriginalExtention();
        $request->image->move(public_path('images'),$imageName);
        return $imageName;
    }
}