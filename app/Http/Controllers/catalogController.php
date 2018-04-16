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
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $image = $this->postImage($request, $name);
        $category = $request->input('category');
                catalog::create([
                    'name'=>$name,
                    'description'=>$description,
                    'price'=>$price,
                    'image'=>$image,
                    'category'=>$category,
                ]);
            return redirect()->route('shopList');
    }
    function EditProduct($name) {
        $catalogs = new catalog();
        $catalog = $catalogs->where( 'name', '=', $name);
        return view('altProduct', compact('catalog'));
    }
    function postEditProduct($oldName, $name, $description, $price, $image, $category)
    {
        catalog::findOrFail($oldName)->update(['name'=>$name,'description'=>$description,'price'=>$price,'image'=>$image,'category',$category]);
        return redirect()->route('shop');
    }
    function removeProduct($name)
    {
        $catalogs = new catalog();
       $deletedProduct = $catalogs->where(['name' => $name]);
       $deletedProduct->delete();
       return redirect()->route('shopList');
    }
    function showCatalog() {
        return view('shop');
    }
    function APIShowByCategory($category){
        $catalogs = new catalog();
        $shop = $catalogs->where('category','=',$category);
        return response()->json($shop);
    }
    function APICatalog() {
        $catalog = New catalog();

        $shop = $catalog->all();

        return response()->json($shop);
    }


    function postImage($request, $name) {
        $this->validate($request, [ 'image' => 'required|image|mimes:jpeg,png,gif,svg|max:1024',]);
    //    $imageName = $name.'.'.$request->image->getClientOriginalExtention();
    //    $request->image->move(storage_path('app'),$imageName);
        $image = $request->image;
        $imageName = $image->store('catalog');
        return $imageName;
    }
    function showImage ($image) {
        $thisImage = Storage::get($image);
        return $thisImage;
    }
}