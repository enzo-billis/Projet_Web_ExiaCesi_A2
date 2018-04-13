<?php
/**
 * Created by PhpStorm.
 * User: Tristan
 * Date: 11/04/2018
 * Time: 15:27
 */

namespace App\Http\Controllers;


use App\catalog;

class catalogController extends Controller
{
    public function __construct()
    {
    }

    function findProduct($name)
    {
        return catalog::findOrFail($name);
    }
    function addProduct()
    {
        return view('newProduct', compact('nProduct'));
    }
    function PostAddProduct($name, $description, $price, $image, $category)
    {
        if (!$this->findProduct($name))
            {
                catalog::create([
                    'name'=>$name,
                    'description'=>$description,
                    'price'=>$price,
                    'image'=>$image,
                    'category'=>$category
                ]);
            }
            else {
            echo "product already exists";
        }
        return redirect()->route('shop');
    }
    function editProduct($id, $name, $description, $price, $image, $category)
    {
        catalog::findOrFail($id)->update(['name'=>$name,'description'=>$description,'price'=>$price,'image'=>$image,'category',$category]);
        return redirect()->route('shop');
    }
    function removeProduct($name)
    {
       catalog::findOrFail($name)->delete();
       return redirect()->route('shop');
    }
    function showCatalog() {
        $catalog = catalog::all();
        return view('shop', compact('catalog'));
    }
    function APIShowByCategory($category){

    }
    function APICatalog() {
        $catalog = New catalog();

        $shop = $catalog->all();

        return response()->json($shop);
    }
}