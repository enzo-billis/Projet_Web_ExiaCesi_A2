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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image;

class catalogController extends Controller
{
    public function __construct()
    {
    }
/**
 * Find a product depending of the name
 * @param $name
 * @return catalog('manifestation')
 */
    function findProduct($name)
    {
        return catalog::where(['name' => $name]);
    }

    /**
     *
     * @return
     */

    function addProduct()
    {
        return view('newProduct');
    }
    function PostAddProduct(Request $request)
    {
        $image = $request->file('image');
        $filename = time().'.'. $image->getClientOriginalExtension();

        $path = "storage/CatalogPics/".$filename;
        $pathToDb = "/storage/CatalogPics/".$filename;

        Image::make($image->getRealPath())->fit('400','280')->save($path);

        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $image = $pathToDb;
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
        // target : access to modify page of the selected article
        $catalogs = new catalog();
        $catalog = $catalogs->where('name','=',$name)->get();
        return view('altProduct',compact('catalog'));
    }
    function postEditProduct(Request $request)
    {
        $oldName = $request->input('oldname');
        $name = $request->input('name');
        $image = $this->postImage($request);
        $price = $request->input('price');
        $category = $request->input('category');
        $description = $request->input('description');
        $catalog = new Catalog();
        $catalog->where('name', '=',$oldName)->update(
        ['name'=> $name,
        'description'=>$description,
        'image'=>$image,
        'category'=>$category,
        'price'=>$price
        ]);
        return redirect()->route('shopList');
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
    function APIShowByName($name) {
        $catalogs = new catalog();
        $shop = $catalogs->where('name','=',$name);
        return response()->json($shop);

    }
    function APICatalog() {
        $catalog = New catalog();

        $shop = $catalog->all();

        return response()->json($shop);
    }


    function postImage($request) {
        $file = Input::file('');

    }
    function showImage ($image) {
        $thisImage = Storage::put('/public/storage/catalog/',$image);
        return $thisImage;
    }
}