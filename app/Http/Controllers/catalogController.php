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
    function addProduct($name, $description, $price, $image, $category)
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
    }
    function editProduct($oldName, $name, $description, $price, $image, $category)
    {
        catalog::findOrFail($oldName)->update(['name'=>$name,'description'=>$description,'price'=>$price,'image'=>$image,'category',$category]);
    }
    function removeProduct($name)
    {
       catalog::findOrFail($name)->delete();
    }
    function showCatalog() {
        $catalog = catalog::all();
        return view('shop', compact('catalog'));
    }
    function APICatalog() {
        $catalog = New catalog();

        $shop = $catalog->all();

        return response()->json($shop);
    }
}