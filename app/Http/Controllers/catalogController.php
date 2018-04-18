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
     * Find the product depending of the name
     * @param $name
     * @return $this
     */
    function findProduct($name)
    {
        return catalog::where(['name' => $name]);
    }

    /**
     * Access to the add product page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function addProduct()
    {
        return view('newProduct');
    }

    /**
     * Post the new product into the database, and redirect to the shop
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Access to the modification product page depending of the selected product
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function EditProduct($name) {
        // target : access to modify page of the selected article
        $catalogs = new catalog();
        $catalog = $catalogs->where('name','=',$name)->get();
        return view('altProduct',compact('catalog'));
    }

    /**
     * Post all modification into the database, and redirect to the shop
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function postEditProduct(Request $request)
    {
        $image = $request->file('image');
        $filename = time().'.'. $image->getClientOriginalExtension();

        $path = "storage/CatalogPics/".$filename;
        $pathToDb = "/storage/CatalogPics/".$filename;

        Image::make($image->getRealPath())->fit('400','280')->save($path);
        $oldName = $request->input('oldname');
        $name = $request->input('name');
        $image = $pathToDb;
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

    /**
     * Remove a product from the database depending of his name, and redirect to the shop
     * @param $name
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    function removeProduct($name)
    {
        $catalogs = new catalog();
       $deletedProduct = $catalogs->where(['name' => $name]);
       $deletedProduct->delete();
       return redirect()->route('shopList');
    }

    /**
     * Access to the shop view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function showCatalog() {
        return view('shop');
    }

    /**
     * The API used for show product by category
     * @param $category
     * @return \Illuminate\Http\JsonResponse
     */
    function APIShowByCategory($category){
        $catalogs = new catalog();
        $shop = $catalogs->where('category','=',$category);
        return response()->json($shop);
    }

    /**
     * The API used for show product by name
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    function APIShowByName($name) {
        $catalogs = new catalog();
        $shop = $catalogs->where('name','=',$name);
        return response()->json($shop);

    }

    /**
     * The API used for show all product
     * @return \Illuminate\Http\JsonResponse
     */
    function APICatalog() {
        $catalog = New catalog();

        $shop = $catalog->all();

        return response()->json($shop);
    }
}